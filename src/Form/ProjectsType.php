<?php

namespace App\Form;

use App\Entity\Projects;
use App\Entity\Skills;
use Doctrine\ORM\EntityRepository;
use SebastianBergmann\CodeCoverage\Report\Text;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ColorType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProjectsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'label' => 'Nom du projet',
                'attr' => [
                    'placeholder' => 'Entre le nom du projet',
                    'class' => 'form-control'
                ],
            ])
            ->add('description', TextareaType::class, [
                'label' => 'Description du projet',
                'attr' => [
                    'placeholder' => 'Entre la description du projet',
                    'class' => 'form-control'
                ],
            ])
            ->add('color', ColorType::class, [
                'label' => 'Couleur du projet',
                'attr' => [
                    'placeholder' => 'Entre la couleur du projet',
                    'class' => 'form-control'
                ],
            ])
            ->add('skills', EntityType::class, [
                'class' => Skills::class,
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('s')
                        ->orderBy('s.name', 'ASC');
                },
                'choice_label' => 'name',
                'multiple' => true,
                'expanded' => true,
                'by_reference' => false,
                'label' => 'Compétences utilisées dans le projet',
                'attr' => [
                    'placeholder' => 'Entre les compétences utilisées dans le projet',
                    'class' => 'form-control'
                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Projects::class,
        ]);
    }
}
