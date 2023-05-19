<?php

namespace App\Controller\Admin;

use App\Entity\Peinture;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\CollectionField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\NumberField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class PeintureCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Peinture::class;
    }

    
    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->hideOnForm(),
            TextField::new('nom'),
            NumberField::new('largeur'),
            NumberField::new('hauteur'),
            NumberField::new('prix'),
            BooleanField::new('en_vente'),
            DateTimeField::new('date_realisation'),
            TextField::new('description'),
            AssociationField::new('Commentaires'),
            AssociationField::new('Categories'),

        ];
    }
    
}
