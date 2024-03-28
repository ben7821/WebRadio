<?php

namespace App\Form;

use App\Entity\Participant;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class ParticipantType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('PRENOM', TextType::class, [
                'label' => 'Prénom',
                'mapped' => true,
            ])
            ->add('NOM', TextType::class, [
                'label' => 'Nom',
                'mapped' => true,
            ])
            ->add('TEL', TextType::class, [
                'label' => 'Téléphone',
                'mapped' => true,
            ])
            ->add('MAIL', TextType::class, [
                'label' => 'Email',
                'mapped' => true,
            ])
            ->add('INSCRIPTION', HiddenType::class, [
                'mapped' => false,
                'data' => '1',
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Participant::class,
        ]);
    }
}
