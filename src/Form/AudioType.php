<?php

namespace App\Form;

use App\Entity\Audio;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Validator\Constraints\File as ConstraintsFile;

class AudioType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('NOM')
            ->add('DESCRIPTION')
            ->add('HEURE')
            ->add('DATE')
            ->add('AUDIO', FileType::class, [
                'label' => 'Audio (WAV)',
                'mapped' => true,
                'required' => false,
                'constraints' => [
                    new ConstraintsFile([
                        'maxSize' => '256144k',
                        'mimeTypes' => [
                            'audio/wav',
                            'audio/x-wav'
                        ],
                        'mimeTypesMessage' => 'Please upload a valid WAV document',
                    ])
                ],
            ])
            ->add('AUTEURS')
            ->add('IDEMISSION')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Audio::class,
        ]);
    }
}
