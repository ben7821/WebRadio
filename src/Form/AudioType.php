<?php

namespace App\Form;

use App\Entity\Audio;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Validator\Constraints\File as ConstraintsFile;
use App\Form\StringToFileTransformer;

class AudioType extends AbstractType
{
    private $transformer;

    public function __construct(StringToFileTransformer $transformer)
    {
        $this->transformer = $transformer;
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('NOM')
            ->add('DESCRIPTION')
            ->add('HEURE')
            ->add('DATE')
            ->add(
                'AUDIO',
                FileType::class,
                [
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
                ]
            )
            ->add('AUTEURS')
            ->add('IDEMISSION');

        $this->transformer->setDirectory($options['dir']);
        $builder->get('AUDIO')->addModelTransformer($this->transformer);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Audio::class,
            'dir' => null,
        ]);
    }
}
