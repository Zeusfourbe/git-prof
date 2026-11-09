<?php

namespace App\Form;

use App\Entity\Category;
use App\Entity\Coaster;
use App\Entity\Park;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
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
            ->add('park', EntityType::class, [
                'class' => Park::class,
                'label' => 'Parc',
                'required' => false,
                'placeholder' => 'Aucun parc',
                'attr' => ['class' => 'select select-bordered w-full'],
            ])
            ->add('categories', EntityType::class, [
                'class' => Category::class,
                'label' => 'Catégories',
                'choice_label' => 'name',
                'multiple' => true,
                'expanded' => true,
                'attr' => ['class' => 'flex flex-wrap gap-x-5 gap-y-2'],
                'required' => false,
                'by_reference' => false,
                'query_builder' => fn (EntityRepository $er) => $er->createQueryBuilder('c')->orderBy('c.name', 'ASC'),
                'choice_attr' => fn () => ['class' => 'checkbox'],
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
