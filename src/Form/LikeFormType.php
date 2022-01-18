<?php

namespace App\Form;

use App\Entity\Advert;
use App\Entity\AdvertLike;
use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\ButtonType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class LikeFormType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {

        $builder

            ->add('advert', EntityType::class ,
                ['required'=> true,
                    'class' => Advert::class,
                    'attr' => ['class'=> 'hidden'],
                    'choice_value'=> 'id'
                ])
            ->add('user', EntityType::class ,
                ['required'=> true,
                    'class' => User::class,
                    'attr' => ['class'=> 'hidden'],
                    'choice_value'=> 'id'
                ])
            ->add('button', SubmitType::class ,
                [ 'label' => 'Like']
            );
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => AdvertLike::class,
        ]);
    }
}
