<?php

namespace App\Form;

use App\Entity\Week;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class WeekType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('fk_monday')
            ->add('fk_tuesday')
            ->add('fk_wednesday')
            ->add('fk_thursday')
            ->add('fk_friday')
            ->add('fk_saturday')
            ->add('fk_sunday') 
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Week::class,
        ]);
    }
}
