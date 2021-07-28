<?php

namespace App\Form;

use App\Entity\Annonces;
use App\Entity\Arrondissement;
use App\Entity\Commune;
use App\Entity\Departement;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AnnoncesType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title')
            ->add('description')
            ->add('price')
            ->add('type', ChoiceType::class, [
                'choices' => $this->getChoices(),
                'label' => 'Type du bien'
            ])
            ->add('surface')
            ->add('rooms')
            ->add('bedrooms')
            ->add('location')
            ->add('sold')
            // On ajoute le champ "images" dans le formulaire
            // Il n'est pas lié à la base de données (mapped à false)
            ->add('images', FileType::class, [
                'label' => 'Image (JPG or PNG file)',
                'multiple' => true,
                'mapped' => false,
                'required' => false
            ])
            ->add('departement', EntityType::class, [
                'class' => 'App\Entity\Departement',
                'placeholder' => 'Selectionnez un département',
                'mapped' => false,
                'required' => false
            ]);
        $builder->get('departement')->addEventListener(
            FormEvents::POST_SUBMIT,
            function (FormEvent $event){
                $form = $event->getForm();
                $this->addCommuneField($form->getParent(), $form->getData());
            }
        );
        $builder->addEventListener(
            FormEvents::POST_SET_DATA,
            function(FormEvent $event) {
                $data = $event->getData();
                /* @var $quartier Quartier */
                $quartier = $data->getQuartier();
                $form = $event->getForm();
                if ($quartier) {
                    $arrondissement = $quartier->getArrondissement();
                    $commune = $arrondissement->getCommune();
                    $departement = $commune->getDepartement();
                    $this->addCommuneField($form, $departement);
                    $this->addArrondissementField($form, $commune);
                    $this->addQuartierField($form, $arrondissement);
                    $form->get('departement')->setData($departement);
                    $form->get('commune')->setData($commune);
                    $form->get('arrondissement')->setData($arrondissement);
                }else{
                    $this->addCommuneField($form, null);
                    $this->addArrondissementField($form, null);
                    $this->addQuartierField($form, null);
                }
            }
        );

    }

    //Ajout du champ commune au formulaire
    private function addCommuneField(FormInterface $form, ?Departement $departement){
        $builder = $form->getConfig()->getFormFactory()->createNamedBuilder(
            'commune',
            EntityType::class,
            null,
            [
                'class' => 'App\Entity\Commune',
                'placeholder' => $departement ? 'Selectionnez une commune' : 'Sélectionnez d\'abord votre département',
                'mapped' => false,
                'required' => false,
                'auto_initialize' => false,
                'choices' => $departement ? $departement->getCommunes() : []
            ]
        );
        $builder->addEventListener(
            FormEvents::POST_SUBMIT,
            function (FormEvent $event){
                $form = $event->getForm();
                $this->addArrondissementField($form->getParent(), $form->getData());
            }
        );
        $form->add($builder->getForm());
    }

    //Ajout du champ arrondissement au formulaire
    private function addArrondissementField(FormInterface $form, ?Commune $commune){
        $builder = $form->getConfig()->getFormFactory()->createNamedBuilder(
            'arrondissement',
            EntityType::class,
            null,
            [
                'class' => 'App\Entity\Arrondissement',
                'placeholder' => $commune ? 'Selectionnez un arrondissement' : 'Sélectionnez d\'abord votre commune',
                'mapped' => false,
                'required' => false,
                'auto_initialize' => false,
                'choices' => $commune ? $commune->getArrondissements() : []
            ]
        );
        $builder->addEventListener(
            FormEvents::POST_SUBMIT,
            function (FormEvent $event){
                $form = $event->getForm();
                $this->addQuartierField($form->getParent(), $form->getData());
            }
        );
        $form->add($builder->getForm());
    }

    //Ajout du champ quartier au formulaire
    private function addQuartierField(FormInterface $form, ?Arrondissement $arrondissement){
        $form->add('quartier', EntityType::class, [
            'class' => 'App\Entity\Quartier',
            'placeholder' => $arrondissement ? 'Sélectionnez un quartier' : 'Sélectionnez d\'abord votre arrondissemnt',
            'required' => false,
            'attr' => ['class' => 'form-control'],
            'choices' => $arrondissement ? $arrondissement->getQuartiers() : []
        ]);
    }


    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Annonces::class,
        ]);
    }

    public function getChoices() 
    {
        $choices = Annonces::TYPE;
        $output = [];
        foreach($choices as $k => $v) {
            $output[$v] = $k;
        }
        return $output;
    }
}
