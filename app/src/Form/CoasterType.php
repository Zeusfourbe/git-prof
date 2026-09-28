<?php

namespace App\Form;

use App\Entity\Coaster;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CoasterType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'label' => 'Nom',
                'attr' => ['class' => 'input input-bordered w-full'],
            ])
            ->add('maxSpeed', IntegerType::class, [
                'label' => 'Vitesse max',
                'required' => false,
                'attr' => ['class' => 'input input-bordered w-full'],
            ])
            ->add('length', IntegerType::class, [
                'label' => 'Longueur',
                'required' => false,
                'attr' => ['class' => 'input input-bordered w-full'],
            ])
            ->add('maxHeight', IntegerType::class, [
                'label' => 'Hauteur max',
                'required' => false,
                'attr' => ['class' => 'input input-bordered w-full'],
            ])
            ->add('operating', CheckboxType::class, [
                'label' => 'En service',
                'required' => false,
                'attr' => ['class' => 'checkbox'],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Coaster::class,
        ]);
    }
}
