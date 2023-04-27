<?php

namespace App\Controller;
use App\Entity\ReponseR;
use App\Entity\Reclamation;
use App\Entity\PropertySearch;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\ReclamationRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Form\PropertySearchType;
use App\Entity\EmailSearch;
use App\Form\EmailSearchType;






class ReclamationController extends AbstractController
{

    
   /**
 * @Route("/Reclamation/new", name="new_Reclamation")
 * Method({"GET", "POST"})
 */
public function create(Request $request )
{
    // Création d'un nouvel objet Réclamation
    $reclamation = new Reclamation();

    // Création du formulaire pour saisir une nouvelle réclamation
    $form = $this->createFormBuilder($reclamation)
        ->add('nom', TextType::class)
        ->add('email', TextType::class)
        ->add('objet', TextType::class)
        ->add('texteReclamation', TextareaType::class, [
            'label' => 'Contenu'])
        ->add('envoyer', SubmitType::class, [
                'label' => 'Envoyer'])
        
        ->getForm();

    // Traitement de la soumission du formulaire
    $form->handleRequest($request);
    if ($form->isSubmitted() && $form->isValid()) {
        // Récupération des données saisies dans le formulaire
        $reclamation = $form->getData();
        
        $reclamation->setValide(false);
        // Récupération de l'EntityManager
        $entityManager = $this->getDoctrine()->getManager();

        // Ajout de la nouvelle réclamation à l'EntityManager
        $entityManager->persist($reclamation);

        // Enregistrement des modifications dans la base de données
        $entityManager->flush();
  

       
       $this->addFlash('success', 'Réclamation ajoutée avec succès');

        // Redirection vers la liste des réclamations
        return $this->redirectToRoute('reclamations_list');
    }

    // Affichage du formulaire pour saisir une nouvelle réclamation
    return $this->render('reclamation/new.html.twig', array(
        'form' => $form->createView(),
    ));
}


/** 
*@Route("/",name="reclamations_list") 
*/ 


public function home(Request $request) 
{ 
    $emailSearch= new EmailSearch(); 
    $form = $this->createForm(EmailSearchType::class,$emailSearch); 
    $form->handleRequest($request); 
    //initialement le tableau  de la reclamationdes  est vide, 
    //c.a.d on affiche  la reclamation que lorsque l'utilisateur 
    //clique sur le bouton rechercher 
    $reclamation= []; 
    if($form->isSubmitted() && $form->isValid()) { 
    //on récupère lobjet de la reclamation tapé dans le formulaire 
    
    $email = $emailSearch->getEmail(); 
    if ($email!="") 
    //si on a fourni lobjet de la reclamation on affiche les reclamation ayant ce objet 
    $reclamation= $this->getDoctrine()->getRepository(Reclamation::class)->findBy(['email' => $email] ); 
    else 
    //si si aucun objet n'est fourni on affiche tous les reclamation
    $reclamation= $this->getDoctrine()->getRepository(Reclamation::class)->findAll(); 
    } 
    return $this->render('reclamation/index.html.twig',[ 'form' =>$form->createView(), 'reclamation' => $reclamation]); 
    }  
/**
 * @Route("/reclamation/valider/{id}", name="reclamation_valider")
 */

 function validation($reponse) {
    if (empty($reponse)) {
      return "non";
    } else {
      return "oui";
    }
  }




/** 
* @Route("/reclamation/{id}", name="reclamation_detail") 
*/ 
public function show($id) { 
    $reclamation = $this->getDoctrine()->getRepository(Reclamation::class) 
    ->find($id); 
    return $this->render('reclamation/detail.html.twig', 
    array('reclamation' => $reclamation)); 
    } 

 

/** 
* @Route("/reclamation/delete/{id}",name="delete_reclamation") 
* @Method({"DELETE"}) 
*/ 

    public function delete(Request $request, Reclamation $reclamation, EntityManagerInterface $entityManager)
{
    $reclamationRepository = $this->getDoctrine()->getRepository(Reclamation::class);

    // Supprimer tous les enregistrements correspondants dans la table `reponse_r`
    $reclamationRepository->deleteReponseByReclamation($reclamation);

    // Supprimer la ligne dans la table `reclamation`
    $entityManager->remove($reclamation);
    $entityManager->flush();

    $this->addFlash('success', 'Reclamation supprimée avec succès.');
    return $this->redirectToRoute('reclamations_list'); 
    
}

}
