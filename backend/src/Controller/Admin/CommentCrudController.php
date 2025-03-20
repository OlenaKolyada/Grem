<?php

namespace App\Controller\Admin;

use App\Entity\Comment;
use App\Enum\CommentStatusEnum;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use Symfony\Component\Form\Extension\Core\Type\EnumType;

class CommentCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Comment::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular('Comment')
            ->setEntityLabelInPlural('Comments');
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->hideOnForm(),
            TextEditorField::new('content'),

            ChoiceField::new('status', 'Status')
                ->setFormType(EnumType::class)
                ->setFormTypeOptions(['class' => CommentStatusEnum::class,])
                ->setChoices(CommentStatusEnum::cases()),

            AssociationField::new('author')
                ->setFormTypeOptions(['choice_label' => 'nickname']),

            AssociationField::new('review')
                ->setFormTypeOptions(['choice_label' => 'title']),
        ];
    }
}