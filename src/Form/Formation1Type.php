<?php

namespace App\Form;
use App\Entity\Artiste;
use App\Entity\Categorie;
use App\Entity\Formation;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\EntityType;
use Symfony\Component\Validator\Constraints as Assert;

// Import the Captcha Field Type and Validator
use Captcha\Bundle\CaptchaBundle\Form\Type\CaptchaType;
use Captcha\Bundle\CaptchaBundle\Validator\Constraints\ValidCaptcha;


class Formation1Type extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('titre')
        ->add('description')
        ->add('lien', UrlType::class)
        ->add('date', DateType::class, [
            'constraints' => [
                new Assert\GreaterThanOrEqual([
                    'value' => 'today',
                    'message' => 'Date cannot be in the past.',
                ]),
            ],
        ])
        ->add('artiste', EntityType::class, [
            'class' => Artiste::class,
            'choice_label' => 'login', // or any property of Artiste you want to use as a label
        ])
        ->add('type', EntityType::class, [
            'class' => Categorie::class])
        ->add('captchaCode', CaptchaType::class, array(
                'captchaConfig' => 'ExampleCaptchaUserRegistration',
                'constraints' => [
                    new ValidCaptcha([
                        'message' => 'Invalid captcha, please try again',
                    ]),
                ],
            ))
            ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Formation::class,
        ]);
    }
}
