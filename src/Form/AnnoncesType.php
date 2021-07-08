<?php

namespace App\Form;

use App\Entity\Annonces;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Vich\UploaderBundle\Form\Type\VichImageType;

class AnnoncesType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title')
            ->add('description')
            ->add('price')
            ->add('surface')
            ->add('rooms')
            ->add('bedrooms')
            // On ajoute le champ "images" dans le formulaire
            // Il n'est pas lié à la base de données (mapped à false)
            ->add('images', FileType::class, [
                'label' => 'Image (JPG or PNG file)',
                'multiple' => true,
                'mapped' => false,
                'required' => true,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Annonces::class,
        ]);
    }
}
