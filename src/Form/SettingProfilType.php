<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SettingProfilType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('username', TextType::class, [
                'required' => false,
                'label' => false,
                'attr' => [
                    'placeholder' => 'username',
                    'class' => 'form-control text-center text-black',
                    'id' => 'nom'
                ]
            ])
            ->add('channels', TextType::class, [
                'required' => false,
                'label' => false,
                'attr' => [
                    'placeholder' => 'nom de la chaine',
                    'class' => 'form-control text-center text-black',
                    'id' => 'nomChaine'
                ]
            ])
            ->add('password', PasswordType::class, [
                'required' => false,
                'label' => false,
                'attr' => [
                    'placeholder' => 'Mot de passe',
                    'class' => 'form-control text-center text-black',
                    'id' => 'mdp'
                ]
            ])
            
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
