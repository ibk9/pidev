<?php

namespace App\Controller;

use App\Entity\Artiste;
use App\Entity\Categorie;
use App\Entity\Formation;
use App\Form\FormationType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\HttpFoundation\Session\Flash\FlashBagInterface;
use Symfony\Bundle\FlashBundle;
use Knp\Component\Pager\PaginatorInterface;
use Knp\Component\Pager\Pagination\PaginationInterface;
use Knp\Bundle\PaginatorBundle\Pagination\SlidingPaginationInterface;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;


#[Route('/formation/controller/admin')]
class FormationControllerAdminController extends AbstractController
{   

    #[Route('/', name: 'app_formation_controller_admin_index', methods: ['GET', 'POST'])]
    public function index(Request $request, EntityManagerInterface $entityManager, PaginatorInterface $paginator): Response
    {
                
        $formations = [];
    
        $form = $this->createFormBuilder(null, [
            'method' => 'POST', // Set the default method to POST
        ])
        ->add('type', EntityType::class, [
            'class' => Categorie::class,
            'label' => 'Type',
            'placeholder' => 'Choose a type',
        ])
        ->add('artiste', EntityType::class, [
            'class' => Artiste::class,
            'label' => 'Artiste',
            'placeholder' => 'Choose an artist',
        ])
        ->getForm();

    $form->handleRequest($request);    
    
    // Create the query builder for the search
    $queryBuilder = $entityManager->getRepository(Formation::class)
        ->createQueryBuilder('f')
        ->andWhere('f.archive = :archive')
        ->setParameter('archive', 'false');

        if ($form->isSubmitted() && $form->isValid()) {
            $type = $form->get('type')->getData();
            $artiste = $form->get('artiste')->getData();
            $queryBuilder = $this->searchFormations($type, $artiste, $entityManager);
            $query = $queryBuilder->andWhere('f.archive = :archive')
                ->setParameter('archive', 'false')
                ->getQuery();
                
                $pagination = $paginator->paginate(
                $query, // Requête contenant les données à paginer (ici nos articles)
                $request->query->getInt('page', 1),5,); // Nombre de résultats par page
    
            $formations = $pagination->getItems();
        } else {
            $queryBuilder = $entityManager->getRepository(Formation::class)
            ->createQueryBuilder('f')
            ->andWhere('f.archive = :archive')
            ->setParameter('archive', 'false');
            $query = $queryBuilder->getQuery();
            $pagination = $paginator->paginate(
                $query, // Requête contenant les données à paginer (ici nos articles)
                $request->query->getInt('page', 1),5,); // Nombre de résultats par page
    
            $formations = $pagination->getItems();
        }
    
        return $this->render('formation_controller_admin/index.html.twig', [
            'form' => $form->createView(),
            'formations' => $formations,
            'pagination' => $pagination,
        ]);
    }
    
private function searchFormations($type, $artiste, EntityManagerInterface $entityManager)
{
    // Find formations by type and artiste
    $queryBuilder = $entityManager->createQueryBuilder()
        ->select('f')
        ->from(Formation::class, 'f')
        ->where('f.type = :type')
        ->andWhere('f.artiste = :artiste')
        ->andWhere('f.archive = :archive')
        ->setParameter('archive', 'false')
        ->setParameter('type', $type)
        ->setParameter('artiste', $artiste);

    return $queryBuilder;
}
                
    
    #[Route('/new', name: 'app_formation_controller_admin_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $formation = new Formation();
        $form = $this->createForm(FormationType::class, $formation);
        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) {
        
            $entityManager->persist($formation);
            $entityManager->flush();
            $this->addFlash('success', 'Formation created successfully');

            return $this->redirectToRoute('app_formation_controller_admin_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('formation_controller_admin/new.html.twig', [
            'formation' => $formation,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_formation_controller_admin_show', methods: ['GET'])]
    public function show(Formation $formation): Response
    {
        return $this->render('formation_controller_admin/show.html.twig', [
            'formation' => $formation,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_formation_controller_admin_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Formation $formation, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(FormationType::class, $formation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();
            $this->addFlash('success', 'Formation updated successfully');

            return $this->redirectToRoute('app_formation_controller_admin_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('formation_controller_admin/edit.html.twig', [
            'formation' => $formation,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_formation_controller_admin_archive', methods: ['POST'])]
    public function archive(Request $request, Formation $formation, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('archive'.$formation->getId(), $request->request->get('_token'))) {
        $formation->setArchive('true'); // Set the "archive" attribute to "true"
        $entityManager->flush(); // Persist the changes to the database
        $this->addFlash('success', 'Formation archived successfully');
        }

        return $this->redirectToRoute('app_formation_controller_admin_index', [], Response::HTTP_SEE_OTHER);
    }


}
