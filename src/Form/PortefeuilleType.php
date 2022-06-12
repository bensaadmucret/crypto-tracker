<?php

namespace App\Form;

use App\Entity\Portefeuille;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;

class PortefeuilleType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'label' => 'Cryptomonnaie',
                'disabled' => true,
                
            ])
            ->add('price', NumberType::class, [
                'required' => true,
                'label' => "Prix d'achat",
                'scale' => 12,
                'grouping' => true,
                'disabled' => true,

            ])
            ->add('quantity', NumberType::class, [
                'required' => true,
                'label' => "Quantité",
                'scale' => 12,
                'grouping' => true,
                'disabled' => true,
                ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Portefeuille::class,
        ]);
    }
}
