<?php

namespace App\Controller;

use App\Entity\ReponseR;
use App\Entity\Reclamation;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use App\Service\NotificationService;

use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;


class ReponseRController extends AbstractController
{
  /**
 * @Route("/reclamation/{id}/reponse", name="reclamation_reponse")
 */


public function repondre(Request $request, Reclamation $reclamation)
{
    // Création d'un nouvel objet ReponseR
    
    $reponse = new ReponseR();
    $reponse->setReclamation($reclamation);
    
    


    // Création du formulaire pour saisir une nouvelle réponse
    $form = $this->createFormBuilder($reponse)
 
    ->add('contenu', TextType::class)
    ->add('date', DateTimeType::class, [
        'widget' => 'single_text',
        'html5' => false,
        'data' => new \DateTime(),
        'attr' => ['class' => 'js-datepicker'],
    ])
    ->add('reclamation', EntityType::class, [
        'class' => Reclamation::class,
        'choice_label' => 'objet',
    ])
    ->add('save', SubmitType::class, ['label' => 'Répondre'])
    ->getForm();
       
        

    // Traitement de la soumission du formulaire
    $form->handleRequest($request);
    if ($form->isSubmitted() && $form->isValid()) {
        // Récupération des données saisies dans le formulaire
        $reponse = $form->getData();

        // Récupération de l'EntityManager
        $entityManager = $this->getDoctrine()->getManager();

        // Ajout de la nouvelle réponse à l'EntityManager
        $entityManager->persist($reponse);

        // Enregistrement des modifications dans la base de données
        $entityManager->flush();


        // Mise à jour du champ "reponse" de la réclamation
        $reclamation->setReponse($reponse); 
          // Redirection vers la liste des réclamations
          return $this->redirectToRoute('reclamations_list');
        }
    
        // Affichage du formulaire pour saisir une nouvelle réponse
        return $this->render('reclamation/reponse.html.twig', array(
            'form' => $form->createView(),
            'reclamation' => $reclamation
        ));
}

    
}
