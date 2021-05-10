<?php

namespace App\Form;

use App\Entity\Annonces;
use App\Entity\Categories;
use App\Entity\Regions;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RechercheType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder

            ->add('categorie_annonce',EntityType::class,[
                'class'=>Categories::class,
                'choice_label'=>'name_categorie',
                'required'=>false
            ])
            ->add('region_annonce',EntityType::class,[
                'class'=>Regions::class,
                'choice_label'=>'name_region',
                'required'=>false
            ])
            ->add('prixMin',NumberType::class,[
                'label'=>'PrixMin',
                'required'=> false
            ])
            ->add('prixMax',NumberType::class,[
                'label'=>'PrixMax',
                'required'=> false
            ])
            ->add('Recherche', SubmitType::class,[
                'label'=>'Rechercher'
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
