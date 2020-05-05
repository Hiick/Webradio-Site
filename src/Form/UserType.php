<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('username', TextType::class, [
                'required' => false,
                'label' => false,
                'attr' => [
                    'placeholder' => 'username',
                    'class' => 'form-control text-center text-black'
                ]
            ])
            ->add('email', EmailType::class, [
                'required' => false,
                'label' => false,
                'attr' => [
                    'placeholder' => 'Email',
                    'class' => 'form-control text-center text-black'
                ]
            ])
            ->add('roles', ChoiceType::class, [
                'required' => false,
                'label' => false,
                'choices' => $this->getRoleChoices(),
                'attr' => [
                    'class' => 'form-control',
                    'id'    => 'sel1',
                ]
            ])    
            ->add('channels', TextType::class, [
                'required' => false,
                'label' => false,
                'attr' => [
                    'placeholder' => 'Chaînes',
                    'class' => 'form-control text-center text-black'
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
            'translation_domain' => 'forms'
        ]);
    }

    private function getRoleChoices()
    {
        $choicesRole = User::DefaultRole;
        foreach($choicesRole as $k => $v) {
            $output[$v] = $k;
        }
        return $output;

    }
}
