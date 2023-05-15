<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class RegistrationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email', null, array("attr" => ["class" => "form-control my-3 w-100", "placeholder" => "Write a Email"], "label" => "Email: "))
            ->add('fname', TextType::class, array("attr" => ["class" => "form-control w-100", "placeholder" => "Write your First Name"], "label" => "First Name: "))
            ->add('lname', TextType::class, array("attr" => ["class" => "form-control w-100", "placeholder" => "Write your Last Name"], "label" => "Last Name: "))
            ->add('date_of_birth', DateType::class, [
                'attr' => ['class' => 'form-control w-100', 'style' => 'margin-bottom:15px; width: 95%;'],
                'widget' => 'single_text',
            ])
            ->add('phone', TextType::class, array("attr" => ["class" => "form-control w-100", "placeholder" => "Write your Phone Number"], "label" => "Phone: "))
            ->add('gender', ChoiceType::class, [
                'attr' => ['class' => 'form-control w-100', 'style' => 'margin-bottom:15px; width: 95%;'],
                'choices' => [
                    'Select a gender:' => '',
                    'Male' => "Male",
                    'Female' => "Female",
                    'Divers' => "Divers"
                ], "label" => 'Gender:'
            ])

            ->add('blocked', null, array("attr" => ["class" => "d-none w-100"], 'label' => false))
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
                'attr' => ['class' => 'form-control w-100', 'style' => 'margin-bottom:15px; width: 95%;']
            ])
            // ->add('agreeTerms', CheckboxType::class, [
            // 'mapped' => false,
            // 'constraints' => [
            //     new IsTrue([
            //         'message' => 'You should agree to our terms.',
            //     ]),
            // ],
            // ])
            ->add('plainPassword', PasswordType::class, [
                // instead of being set onto the object directly,
                // this is read and encoded in the controller
                'mapped' => false,
                'attr' => ['autocomplete' => 'new-password', "class" => "form-control w-100", "placeholder" => "Write a Password"],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Please enter a password',
                    ]),
                    new Length([
                        'min' => 6,
                        'minMessage' => 'Your password should be at least {{ limit }} characters',
                        // max length allowed by Symfony for security reasons
                        'max' => 4096,
                    ]),
                ],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
