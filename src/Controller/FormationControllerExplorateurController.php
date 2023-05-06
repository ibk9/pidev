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



#[Route('/formation/controller/explorateur')]
class FormationControllerExplorateurController extends AbstractController
{

    #[Route('/', name: 'app_formation_controller_explorateur_index', methods: ['GET', 'POST'])]
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
    
        return $this->render('formation_controller_explorateur/index.html.twig', [
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
                
    #[Route('/{id}', name: 'app_formation_controller_explorateur_show', methods: ['GET'])]
    public function show(Formation $formation): Response
    {
        return $this->render('formation_controller_explorateur/show.html.twig', [
            'formation' => $formation,
        ]);
    }
}
