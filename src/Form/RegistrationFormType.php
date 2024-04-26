<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\BirthdayType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Regex;

class RegistrationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('firstName', TextType::class, [
                'label' => 'Имя',
                'attr' => [
                    'placeholder' => 'Имя'
                ],
                'constraints' => [
                    new NotBlank(),
                    new Regex('/^[^\d]*$/', message: 'В имени не должно быть цифр!')
                ]
            ])
            ->add('secondName', TextType::class, [
                'label' => 'Фамилия',
                'attr' => [
                    'placeholder' => 'Фамилия'
                ],
                'constraints' => [
                    new NotBlank(),
                    new Regex('/^[^\d]*$/', message: 'В фамилии не должно быть цифр!')
                ]
            ])
            ->add('thirdName', TextType::class, [
                'label' => 'Отчество',
                'attr' => [
                    'placeholder' => 'Отчество'
                ],
                'constraints' => [
                    new NotBlank(),
                    new Regex('/^[^\d]*$/', message: 'В отчестве не должно быть цифр!')
                ]
            ])
            ->add('email', EmailType::class, [
                'label' => 'email',
                'attr' => [
                    'placeholder' => 'email'
                ],
                'constraints' => [
                    new NotBlank(),
                ]
            ])
            ->add('password', PasswordType::class, [
                'label' => 'Пароль',
                'attr' => [
                    'placeholder' => 'Пароль'
                ],
                'constraints' => [
                    new NotBlank(),
                ]
            ])
            ->add('birthdayDate', BirthdayType::class, [
                'label' => 'Дата рождения',
            ])
            ->add('photo', FileType::class, [
                'label' => 'Фото',
                'data_class' => null,
                'required' => false,
                'empty_data' => '',
                'constraints' => [
                    new File([
                        'maxSize' => '4M',
                        'mimeTypes' => [
                            'image/jpeg',
                            'image/png',
                            'image/webp'
                        ],
                        'mimeTypesMessage' => 'Пожалуйста, загрузите изображение в формате JPEG, PNG',
                    ])
                ]
            ])
            ->add("submit", SubmitType::class, [
                'attr' => [
                    'class' => 'submit text-white',
                ],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver
            ->setDefaults([
                'attr' => ['id' => 'register-id']
            ]);
    }
}