<?php

namespace App\Controller\Admin;

use App\Entity\Photo;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use Vich\UploaderBundle\Form\Type\VichImageType;


class PhotoCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Photo::class;
    }


    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id') -> hideOnForm(),
            AssociationField::new('gallery'),
            TextField::new('imageFile')->setFormType(VichImageType::class)->hideOnIndex(),
            ImageField::new('image')->setBasePath('/img/couverture')->onlyOnIndex(),
        ];
    }

}
