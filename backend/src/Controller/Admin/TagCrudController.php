<?php

namespace App\Controller\Admin;

use App\Entity\Tag;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class TagCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Tag::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular('Tag')
            ->setEntityLabelInPlural('Tags');
    }
    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->hideOnForm(),
            TextField::new('title'),

            TextField::new('slug')
                ->onlyOnForms(),
        ];
    }
}
