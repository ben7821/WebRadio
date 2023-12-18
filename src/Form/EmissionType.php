<?php

namespace App\Form;

use App\Entity\Emission;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EmissionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('NOM')
            ->add('NOMLONG')
            ->add('DESCRIPTION')
            ->add('IMG')
            ->add('INSCRIPTION')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Emission::class,
        ]);
    }
}
