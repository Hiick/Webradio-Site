<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
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
            ->add('email', EmailType::class, [
                'required' => false,
                'label' => false,
                'attr' => [
                    'placeholder' => 'email',
                    'class' => 'form-control text-center text-black',
                    'id' => 'email'
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
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
