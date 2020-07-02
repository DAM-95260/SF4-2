<?php

namespace App\Form;

use App\Entity\Product;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Positive;

class ProductFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, [
                'constraints' => [
                    new NotBlank(['message' => 'Le nom est manquant.']),
                    new Length([
                        'max' => 50,
                        'maxMessage' => 'Le nom ne peut contenir plus de {{ limit }} caractères.'
                    ])
                ]
            ])
            ->add('description', TextareaType::class, [
                'required' => false
            ])
            ->add('price', MoneyType::class, [
                // permet de convertir la valeur de la base en sa représentation commune:
                //      7599    -->     75.99
                'divisor' => 100,
                'constraints' => [
                    new NotBlank(['message' => 'Le prix est manquant.']),
                    new Positive(['message' => 'Le prix doit être positif.'])
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Product::class,
        ]);
    }
}