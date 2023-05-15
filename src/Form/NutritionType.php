<?php

namespace App\Form;

use App\Entity\Nutrition;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class NutritionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('engery')
            ->add('fat')
            ->add('protein')
            ->add('carbs')
            ->add('sugar')
            ->add('ingredients')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Nutrition::class,
        ]);
    }
}
