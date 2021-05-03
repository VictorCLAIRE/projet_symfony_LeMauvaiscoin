<?php

namespace App\Form;

use App\Entity\Annonces;
use App\Entity\Categories;
use App\Entity\Regions;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AnnoncesType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nom_annonce')
            ->add('description_annonce')
            ->add('prix_annonce')
            ->add('photo_annonce', FileType::class,[
                'label'=>'Photo de l\'annonce',
                'required'=>false,
                'data_class'=>null,
                'empty_data'=> 'Aucune imade pour cette annonce'
            ])
            ->add('categorie_annonce', EntityType::class,[
                'class'=>Categories::class,
                'choice_label'=>'name_categorie'
                ])
            ->add('region_annonce', EntityType::class,[
                'class'=>Regions::class,
                'choice_label'=>'name_region'
            ]);

    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Annonces::class,
        ]);
    }
}
