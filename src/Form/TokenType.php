<?php

namespace App\Form;

use App\Entity\Token;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;


class TokenType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {   
        $builder
            ->add('name')
            ->add('slug')
            ->add('symbol')
            ->add('price')
            ->add('change_24h')
            ->add('change_1h')
            ->add('change_7d')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Token::class,
        
        ]);
    }
}
