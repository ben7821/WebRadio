<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ReportType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('reason', null, [
                'label' => 'Raison du signalement',
                'attr' => [
                    'placeholder' => 'Raison du signalement'
                ]
            ])
            ->add('content', null, [
                'label' => 'Contenu du signalement',
                'attr' => [
                    'placeholder' => 'Contenu du signalement'
                ]
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => null,
        ]);
    }
}
