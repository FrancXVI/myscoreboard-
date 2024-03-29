<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $user = $options["data"]; // je récupère la variable User qui es tlié au formulaire dans le contrôleur, dans la méthode createForm()
        $builder
            ->add('pseudo')
            ->add('roles', ChoiceType::class, [
                'choices' => [
                    'Administrateur'    => 'ROLE_ADMIN',
                    'Joueurs'           => 'ROLE_PLAYER',
                    'Arbitre'           => 'ROLE_REFEREE',
                    'Utilisateur'       => 'ROLE_USER'

                ],
                'multiple' => true,
                'expanded' => true
            ])
            ->add('password', TextType::class, [
                'mapped' => false,
                'required' => $user->getId() ? false:true // si l'id n'est pas nul, le champ password n'est pas requis (edit) sinon il l'est (new)
                // on aurait pu écrire
                // 'required' => !$user->getId()
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
