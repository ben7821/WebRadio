<?php

namespace App\Form;

use App\Entity\Equipe;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Validator\Constraints\File as ConstraintsFile;
use App\Form\StringToFileTransformer;

class EquipeType extends AbstractType
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
            ->add('PRENOM')
            ->add('DESCRIPTION')
            ->add('IMG', FileType::class, [
                'label' => 'Image (PNG file)',
                'mapped' => false,
                'required' => false,
                'constraints' => [
                    new ConstraintsFile([
                        'maxSize' => '1024k',
                        'mimeTypes' => [
                            "image/*"
                        ],
                        'mimeTypesMessage' => 'Please upload a valid PNG image',
                    ])
                ],
            ])
        ;

        $this->transformer->setDirectory($options['dir']);

        $builder->get('IMG')->addModelTransformer($this->transformer);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Equipe::class,
            'dir' => null,
        ]);
    }
}
