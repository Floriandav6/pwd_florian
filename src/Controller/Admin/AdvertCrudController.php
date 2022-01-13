<?php

namespace App\Controller\Admin;

use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Filter\EntityFilter;
use App\Entity\Category;
use App\Entity\Advert;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class AdvertCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Advert::class;
    }


    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id') -> hideOnForm(),
            TextField::new('title'),
            AssociationField::new('category'),
            TextEditorField::new('description'),
            TextField::new('brand'),
            TextField::new('price'),
            TextField::new('size'),




        ];
    }
    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setPageTitle(Crud::PAGE_NEW, "Ajouter une annonce")
            ->setPageTitle(Crud::PAGE_EDIT, "Modifier une annonce");

    }

}
