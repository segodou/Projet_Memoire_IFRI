<?php

namespace App\Form;

use App\Entity\Annonces;
use App\Entity\Arrondissement;
use App\Entity\Commune;
use App\Entity\Departement;
use App\Entity\Market;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;

class AnnoncesType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', TextType::class, [
                'label' => 'Titre annonce'
            ])
            ->add('description', TextareaType::class, [
                'label' => 'Description'
            ])
            ->add('price', IntegerType::class, [
                'label' => 'Prix'
            ])
            ->add('type', ChoiceType::class, [
                'choices' => $this->getChoices(),
                'label' => 'Type du bien'
            ])
            ->add('surface', IntegerType::class, [
                'label' => 'Surface (m²)'
            ])
            ->add('rooms', IntegerType::class, [
                'label' => 'Nombre(s) de Pièce(s)'
            ])
            ->add('bedrooms', IntegerType::class, [
                'label' => 'Nombre(s) de Chambre(s)'
            ])
            ->add('location', TextType::class, [
                'label' => 'Coordonnées (Latitude,Longitude) '
            ])
            ->add('sold', CheckboxType::class, [
                'label' => 'Vendu'
            ])
            ->add('approved', CheckboxType::class, [
                'label' => 'vendu'
            ])
            // On ajoute le champ "images" dans le formulaire
            // Il n'est pas lié à la base de données (mapped à false)
            ->add('images', FileType::class, [
                'label' => 'Image (JPG or PNG file)',
                'multiple' => true,
                'mapped' => false,
                'required' => false
            ])
            ->add('titleM', TextType::class, [
                'mapped' => false,
                'required' => false,
                'label' => 'Intitulé du marché',
                'constraints' => [
                    new NotBlank,
                ]
            ])
            ->add('adresseM', TextType::class, [
                'mapped' => false,
                'required' => false,
                'label' => 'Coordonnées (Latitude,Longitude)',
                'constraints' => [
                    new NotBlank,
                ]
            ])
            ->add('descriptionM', TextareaType::class, [
                'mapped' => false,
                'required' => false,
                'label' => 'A propos du marché',
                'constraints' => [
                    new NotBlank,
                ]
            ])
            ->add('titleSM', TextType::class, [
                'mapped' => false,
                'required' => false,
                'label' => 'Intitulé du supermarché',
                'constraints' => [
                    new NotBlank,
                ]
            ])
            ->add('adresseSM', TextType::class, [
                'mapped' => false,
                'required' => false,
                'label' => 'Coordonnées (Latitude,Longitude)',
                'constraints' => [
                    new NotBlank,
                ]
            ])
            ->add('descriptionSM', TextareaType::class, [
                'mapped' => false,
                'required' => false,
                'label' => 'A propos du supermarché',
                'constraints' => [
                    new NotBlank,
                ]
            ])
            ->add('titleS', TextType::class, [
                'mapped' => false,
                'required' => false,
                'label' => 'Intitulé de l\'établissement',
                'constraints' => [
                    new NotBlank,
                ]
            ])
            ->add('adresseS', TextType::class, [
                'mapped' => false,
                'required' => false,
                'label' => 'Coordonnées (Latitude,Longitude)',
                'constraints' => [
                    new NotBlank,
                ]
            ])
            ->add('descriptionS', TextareaType::class, [
                'mapped' => false,
                'required' => false,
                'label' => 'A propos de l\'établissement',
                'constraints' => [
                    new NotBlank,
                ]
            ])
            ->add('titleH', TextType::class, [
                'mapped' => false,
                'required' => false,
                'label' => 'Intitulé de l\'hopital',
                'constraints' => [
                    new NotBlank,
                ]
            ])
            ->add('adresseH', TextType::class, [
                'mapped' => false,
                'required' => false,
                'label' => 'Coordonnées (Latitude,Longitude)',
                'constraints' => [
                    new NotBlank,
                ]
            ])
            ->add('descriptionH', TextareaType::class, [
                'mapped' => false,
                'required' => false,
                'label' => 'A propos de l\'hopital',
                'constraints' => [
                    new NotBlank,
                ]
            ])
            ->add('titleR', TextType::class, [
                'mapped' => false,
                'required' => false,
                'label' => 'Intitulé du restaurant',
                'constraints' => [
                    new NotBlank,
                ]
            ])
            ->add('adresseR', TextType::class, [
                'mapped' => false,
                'required' => false,
                'label' => 'Coordonnées (Latitude,Longitude)',
                'constraints' => [
                    new NotBlank,
                ]
            ])
            ->add('descriptionR', TextareaType::class, [
                'mapped' => false,
                'required' => false,
                'label' => 'A propos du restaurant',
                'constraints' => [
                    new NotBlank,
                ]
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
