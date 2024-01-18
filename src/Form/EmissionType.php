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
            ->add('IMG',
             FileType::class, [
                'label' => 'Image (JPEG, PNG, GIF)',
                'required' => false, // Définissez à true si vous souhaitez rendre le champ obligatoire
                'mapped' => true, // Cela signifie que ce champ n'est pas mappé sur l'entité directement
                'constraints' => [
                    new ConstraintsFile([
                        'maxSize' => '16384k',
                        'mimeTypes' => [
                            'image/jpeg',
                            'image/png',
                            'image/gif',
                        ],
                        'mimeTypesMessage' => 'Merci de télécharger une image valide',
                    ])
                ],
            ]
            )
            ->add('INSCRIPTION');

        $this->transformer->setDirectory($options['dir']);
        
        // $builder->get('IMG')
        //     ->addModelTransformer($this->transformer);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Emission::class,
            'dir' => null
        ]);
    }

    public function validateName($value, ExecutionContextInterface $context)
    {
        $uppercase = preg_match('@[A-Z]@', $value);

        if (!$uppercase) {
            $context->buildViolation('Le nom doit contenir au moins une majuscule')
                ->atPath('NOM')
                ->addViolation();
        }
    }
}
