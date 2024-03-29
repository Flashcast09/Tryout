<?php

namespace App\Form;

use Symfony\Component\Form\FormTypeInterface;
use App\Form\Add;
use App\Entity\Users;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraint as Assert;

class EditProfileType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        
            ->add('email', EmailType::class, ['attr' => ['class' => 'testpimp form-control mt-1 mb-4'], 'label' => 'E-mail', 'label_attr'=> ['class' => 'testpp']])
            ->add('lastname', TextType::class, ['attr' => ['class' => 'testpimp form-control mt-1 mb-4'], 'label' => 'Nom', 'label_attr'=> ['class' => 'testpp']])
            ->add('firstname', TextType::class, ['attr' => ['class' => 'testpimp form-control mt-1 mb-4'], 'label' => 'Prénom', 'label_attr'=> ['class' => 'testpp']])
            ->add('address', TextType::class, ['attr' => ['class' => 'testpimp form-control mt-1 mb-4'], 'label' => 'Adresse', 'label_attr'=> ['class' => 'testpp']])
            ->add('zipcode', TextType::class, ['attr' => ['class' => 'testpimp form-control mt-1 mb-4'], 'label' => 'Code postal', 'label_attr'=> ['class' => 'testpp']])
            ->add('city', TextType::class, ['attr' => ['class' => 'testpimp form-control mt-1 mb-4'], 'label' => 'Ville', 'label_attr'=> ['class' => 'testpp']])
            
            ->add('Valider', SubmitType::class, ['attr' => ['class' => 'btninfo btn btn-primary mt-1 mb-4']])
           
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Users::class,
        ]);
    }
}
