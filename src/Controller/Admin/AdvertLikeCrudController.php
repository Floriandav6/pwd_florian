<?php

namespace App\Controller\Admin;

use App\Entity\AdvertLike;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class AdvertLikeCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return AdvertLike::class;
    }

    /*
    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id'),
            TextField::new('title'),
            TextEditorField::new('description'),
        ];
    }
    */
}
