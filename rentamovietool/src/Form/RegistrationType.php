<?php

namespace App\Form;

use App\Entity\Loueur;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RegistrationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('Nom', TextType::class, ['attr' => ['placeholder' => "Votre nom"]])
            ->add('Prenom', TextType::class, ['attr' => ['placeholder' => "Votre prénom"]])
            ->add('adresse', TextType::class, ['attr' => ['placeholder' => "Votre adresse"]])
            ->add('ville',TextType::class, ['attr' => ['placeholder' => "Votre ville"]])
            ->add('code_postal', NumberType::class, ['attr' => ['placeholder' => "Votre code postal"]])
            ->add('email', EmailType::class, ['attr' => ['placeholder' => "Votre e-mail"]])
            ->add('telephone', TelType::class, ['label' => "Téléphone", 'attr' => ['placeholder' => "Votre téléphone"]])
            ->add('hash', PasswordType::class, ['label' => "Mot de passe", 'attr' => ['placeholder' => "Mot de passe"]])
            ->add('passwordConfirm', PasswordType::class, ['label' => "Confirmation du mot de passe", 'attr' => ['placeholder' => "Renseignez à nouveau votre mot de passe"]] )
            ->add('presentation', TextareaType::class, ['label' => "Présentation", 'attr' => ['placeholder' => "Présentez-vous en quelques mots..."]]);
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Loueur::class,
        ]);
    }
}
