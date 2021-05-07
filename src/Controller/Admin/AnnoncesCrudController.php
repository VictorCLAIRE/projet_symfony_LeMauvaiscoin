<?php

namespace App\Controller\Admin;

use App\Entity\Annonces;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\NumberField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class AnnoncesCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Annonces::class;
    }


    public function configureFields(string $pageName): iterable
    {
        return [
            IntegerField::new('id','ID')->onlyOnIndex(),
            TextField::new('nom_annonce'),
            TextareaField::new('description_annonce'),
            NumberField::new('prix_annonce'),
            ImageField::new('photo_annonce')->setBasePath("/img/")->setUploadDir("public\img"),
            AssociationField::new('categorie_annonce'),
            AssociationField::new('region_annonce'),
        ];
    }

}
