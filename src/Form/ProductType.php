<?php

namespace App\Form;

use App\Entity\Category;
use App\Entity\Product;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProductType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('Name', TextType::class)
            ->add('Price', MoneyType::class)
            ->add('TTC', CheckboxType::class, [
                'mapped' => false,
                'attr' => ['checked' => 'true'],
                'required' => false
            ])
            ->add('Quantity', IntegerType::class)
            ->add('Category', EntityType::class, [
                'class'=>Category::class
            ])
            ->add('imageUrl', HiddenType::class, array(
                'label' => 'Image',
                'data' => 'https://hbr.org/resources/images/article_assets/2019/11/Nov19_14_sb10067951dd-001.jpg'
            ))
            ->add('Description', TextareaType::class)
            ->add('save', SubmitType::class, ['label' => 'Submit']);

        $builder->addEventListener(FormEvents::POST_SUBMIT, function (FormEvent $event) {
            $data = $event->getData();
            $price = $data->getPrice();
            if (!$event->getForm()->get('TTC')->getData()){
                $data->setPrice($price + ($price*0.2));
            }
            // set new data
            $event->setData($data);
        });
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Product::class,
        ]);
    }
}
