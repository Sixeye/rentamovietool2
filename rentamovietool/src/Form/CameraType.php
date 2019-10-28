<?php

namespace App\Form;

use App\Entity\Camera;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CameraType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('Marque', TextType::class, [
                'attr' => [
                    'placeholder' => 'ex: Sony, Canon...'
                    ]
            ])
            ->add('Modele', TextType::class)
            ->add('Description')
            ->add('Prix', MoneyType::class, [
                'attr' => [
                    'placeholder' => 'Indiquez le montant pour une location journalière'
                ]
            ])
            //->add('slug')
            ->add('image', UrlType::class, [
                'attr' => [
                    'placeholder' => 'Url liée à une image de votre caméra'
                ]
            ])
            //->add('loueur')
            ->add('soumettre', SubmitType::class, [
                'label' => 'Soumettre l\'annonce',
                'attr'  => [
                    'class' => 'btn-outline-dark',
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Camera::class,
        ]);
    }
}
