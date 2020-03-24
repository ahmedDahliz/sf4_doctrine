<?php

namespace App\Form;

use App\Entity\Product;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProductType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('Name', TextType::class)
            ->add('Price', MoneyType::class)
            ->add('Quantity', IntegerType::class)
            ->add('imageUrl', HiddenType::class, array(
                'label' => 'Image',
                'data' => 'https://hbr.org/resources/images/article_assets/2019/11/Nov19_14_sb10067951dd-001.jpg'
            ))
            ->add('Description', TextareaType::class)
            ->add('save', SubmitType::class, ['label' => 'Submit']);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Product::class,
        ]);
    }
}
