<?php

namespace App\Form;

use App\Entity\Meal;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;

class MealType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {

        $builder
            ->add('name', TextType::class, [
                'attr' => ['class' => 'form-control', "placeholder" => "Write the Meal Name", 'style' => 'margin-bottom:15px; width: 95%;']
            ])
            ->add('picture', FileType::class, [
                'label' => 'Picture (Image File)',

                'mapped' => false,

                'required' => false,

                'constraints' => [
                    new File([
                        'maxSize' => '10000k',
                        'mimeTypes' => [
                            'image/png',
                            'image/jpg',
                            'image/jpeg',
                        ],
                        'mimeTypesMessage' => 'Please upload a valid document',
                    ])
                ],
                'attr' => ['class' => 'form-control', 'style' => 'margin-bottom:15px; width: 95%;']
            ])
            ->add('category', ChoiceType::class, [
                'attr' => ['class' => 'form-control', 'style' => 'margin-bottom:15px; width: 95%;'],
                'choices' => [
                    'Category:' => null,
                    'Veggie' => "Veggie",
                    'Vegan' => "Vegan",
                    'Meat' => "Meat",
                    'Healthy' => "Healthy"
                ],
            ])
            ->add('calories', NumberType::class, [
                'attr' => ['class' => 'form-control', "placeholder" => "Write the the Calories an Number", 'style' => 'margin-bottom:15px; width: 95%;']
            ])
            ->add('rating', Numbertype::class, [
                'attr' => ['class' => 'form-control', "placeholder" => "Write a Rating from 1 to 5", 'style' => 'margin-bottom:15px; width: 95%;']
            ])
            ->add('preparation', TextareaType::class, [
                'attr' => ['class' => 'form-control', "placeholder" => "Write the Preparation for the Meal", 'style' => 'margin-bottom:15px; width: 95%;']
            ])
            ->add('cooking_time', Numbertype::class, [
                'attr' => ['class' => 'form-control', "placeholder" => "Write the Cooking Time in Minutes", 'style' => 'margin-bottom:15px; width: 95%;']
            ])
            ->add('ingredients', TextType::class, [
                'attr' => ['class' => 'form-control', "placeholder" => "Write the Ingredients", 'style' => 'margin-bottom:15px; width: 95%;'],
            ])
            ->add('save', SubmitType::class, [
                'label' => 'Submit',
                'attr' => ['class' => 'btn btn-success mybtn', 'style' => 'margin-bottom: 7px;']
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Meal::class,
            'ingredients' => "",
        ]);
    }
}
