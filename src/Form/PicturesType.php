<?php

namespace App\Form;

use App\Entity\Pictures;
use App\Entity\Projects;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Vich\UploaderBundle\Form\Type\VichFileType;

class PicturesType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'label' => 'Nom de l\'image',
                'attr' => [
                    'placeholder' => 'Entre le nom de l\'image',
                    'class' => 'form-control'
                ],
            ])
            ->add('imageFile', VichFileType::class, [
                'label' => 'Image principale',
                'required'      => false,
                'allow_delete'  => false,
                'download_uri' => true,
                'attr' => [
                    'class' => 'form-control'
                ],
            ])
            ->add('isMain', CheckboxType::class, [
                'label' => 'L\'image est principale ?',
                'required' => false,
                'attr' => [
                    'class' => 'form-check-input'
                ],
            ])
            ->add('project', EntityType::class, [
                'class' => Projects::class,
                'label' => 'Projet',
                'attr' => [
                    'class' => 'form-control'
                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Pictures::class,
        ]);
    }
}
