<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;


class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email', EmailType::class, [
                'attr' => ['class' => 'form-control', 'style' => 'margin-bottom:15px; width: 95%;']
            ])
            ->add('fname', TextType::class, [
                'attr' => ['class' => 'form-control', 'style' => 'margin-bottom:15px; width: 95%;'], "label" => "First Name: "
            ])
            ->add('lname', TextType::class, [
                'attr' => ['class' => 'form-control', 'style' => 'margin-bottom:15px; width: 95%;'], "label" => "Last Name: "
            ])
            ->add('date_of_birth', DateType::class, [
                'attr' => ['class' => 'form-control', 'style' => 'margin-bottom:15px; width: 95%;'],
                'widget' => 'single_text',
            ])
            ->add('phone', TextType::class, [
                'attr' => ['class' => 'form-control', 'style' => 'margin-bottom:15px; width: 95%;']
            ])
            ->add('gender', ChoiceType::class, [
                'attr' => ['class' => 'form-control', 'style' => 'margin-bottom:15px; width: 95%;'],
                'choices' => [
                    'Male' => "Male",
                    'Female' => "Female",
                    'Divers' => "Divers"
                ],
            ])
            ->add('blocked', ChoiceType::class, [
                'attr' => ['class' => 'form-control', 'style' => 'margin-bottom:15px; width: 95%;'],
                'choices' => [
                    'False' => "0",
                    'True' => "1",
                ],
            ])
            ->add('image', FileType::class, [
                'label' => 'Picture (Image File)',

                'mapped' => false,

                'required' => false,

                'constraints' => [
                    new File([
                        'maxSize' => '1024k',
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
            ->add('save', SubmitType::class, [
                'label' => 'Submit',
                'attr' => ['class' => 'btn btn-success mybtn', 'style' => 'margin-bottom: 7px;']
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
