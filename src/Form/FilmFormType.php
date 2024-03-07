<?php

namespace App\Form;

use App\Entity\Genre;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\Validator\Constraints\Range;

class FilmFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, [
                'label' => 'Название'
            ])
            ->add('description', TextareaType::class, [
                'label' => 'Описание'
            ])
            ->add('rating', NumberType::class, [
                'label' => 'Рейтинг',
                'constraints' => [
                    new Range([
                        'min' => 1,
                        'max' => 10,
                        'minMessage' => 'Значение должно быть не менее {{ limit }}.',
                        'maxMessage' => 'Значение должно быть не более {{ limit }}.',
                    ]),
                ]
            ])
            ->add('genre', EntityType::class, [
                'label' => 'Жанр',
                'class' => Genre::class,
                'choice_label' => 'genre',
                'multiple' => true,
                'expanded' => true
            ])
            ->add('budget', IntegerType::class, [
                'label' => 'Бюджет $'
            ])
            ->add('country', TextType::class, [
                'label' => 'Страна'
            ])
            ->add('releaseDate', DateType::class, [
                'label' => 'Дата выхода'
            ])
            ->add('image', FileType::class, [
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
            ->add('submit', SubmitType::class, [
                'label' => 'Добавить',
                'attr' => [
                    'class' => 'btn btn-success'
                ]
            ]);
    }
}