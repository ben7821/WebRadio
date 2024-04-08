<?php

namespace App\Form;

use App\Entity\Emission;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Validator\Constraints\Callback;
use Symfony\Component\Validator\Constraints\File as ConstraintsFile;
use Symfony\Component\Validator\Context\ExecutionContextInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use App\Form\StringToFileTransformer;
use Symfony\Component\Validator\Constraints\File;


class EmissionType extends AbstractType
{
    private $transformer;

    public function __construct(StringToFileTransformer $transformer)
    {
        $this->transformer = $transformer;
    }
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('NOM', TextType::class, [
                'constraints' => [
                    new Callback([$this, 'validateName'])
                ]
            ])
            ->add('NOMLONG')
            ->add('DESCRIPTION')
            ->add(
                'IMG',
                FileType::class,
                [
                    'label' => 'Image (JPEG, PNG, GIF)',
                    'required' => false,
                    'mapped' => false,
                    'constraints' => [
                        new File([
                            'maxSize' => '16384k',
                            'mimeTypes' => [
                                'image/jpeg',
                                'image/png'
                            ],
                            'mimeTypesMessage' => 'Merci de télécharger une image valide',
                        ])
                    ],
                ]
            );

        $this->transformer->setDirectory($options["dir"]);

        $builder->get('IMG')->addModelTransformer($this->transformer);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Emission::class,
            'dir' => null,
        ]);
    }

    public function validateName($value, ExecutionContextInterface $context)
    {
        $uppercase = preg_match('@[A-Z]@', $value);

        if (!$uppercase) {
            $context->buildViolation('Le nom doit être en majuscule')
                ->atPath('NOM')
                ->addViolation();
        }
    }
}
