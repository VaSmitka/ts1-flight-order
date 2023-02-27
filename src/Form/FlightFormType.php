<?php

namespace App\Form;

use App\Entity\FlightOrder;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class FlightFormType extends AbstractType
{
    public const DISCOUNT_TYPES = [
        'Student' => 'Student',
        'Senior' => 'Senior',
        'Coupon' => 'Coupon',
        'None' => 'None',
    ];

    public const DESTINATION_TYPES = [
        'Berlin' => 'Berlin',
        'Paris' => 'Paris',
        'London' => 'London',
        'New York' => 'New York',
        'New Delhi' => 'New Delhi',
    ];


    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('firstName', TextType::class, [
                'label' => 'First Name:',
                'label_attr' => [
                    'class' => 'form-label fw-bold'
                ],
                'attr' => [
                    'placeholder' => 'Enter First Name',
                    'class' => 'form-control'
                ],
                'constraints' => [new Length(['max' => 200])],
            ])
            ->add('lastName', TextType::class, [
                'label' => 'Last Name:',
                'label_attr' => [
                    'class' => 'form-label fw-bold'
                ],
                'attr' => [
                    'placeholder' => 'Enter Last Name',
                    'class' => 'form-control'
                ],
                'constraints' => [new Length(['max' => 200])],
            ])
            ->add('email', TextType::class, [
                'label' => 'Email:',
                'label_attr' => [
                    'class' => 'form-label fw-bold'
                ],
                'attr' => [
                    'placeholder' => 'Enter Email',
                    'class' => 'form-control'
                ],
                'constraints' => [new Length(['max' => 200])],
            ])
            ->add('birthDate', DateType::class, [
                'label' => 'Birth Date:',
                'label_attr' => [
                    'class' => 'form-label fw-bold'
                ],
                'attr' => [
                    'placeholder' => 'dd/mm/yyyy',
                    'class' => 'form-control js-datepicker'
                ],
                'widget' => 'single_text',
                'input'  => 'datetime',
            ])
            ->add('destination', ChoiceType::class, [
                'label' => 'Destination:',
                'label_attr' => [
                    'class' => 'form-label fw-bold'
                ],
                'attr' => [
                    'class' => 'form-select'
                ],
                'multiple' => false,
                'expanded' => false,
                'choices' => FlightFormType::DESTINATION_TYPES,
            ])
            ->add('discount', ChoiceType::class, [
                'label' => 'Discount:',
                'label_attr' => [
                    'class' => 'form-label fw-bold'
                ],
                'multiple' => false,
                'expanded' => true,
                'choices' => FlightFormType::DISCOUNT_TYPES,
            ])
            ->add('submit', SubmitType::class, [
                'label' => 'Complete order',
                'attr' => [
                    'class' => 'btn btn-primary'
                ]
            ]);
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => FlightOrder::class,
        ]);
    }
}
