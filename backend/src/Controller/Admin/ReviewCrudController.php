<?php

namespace App\Controller\Admin;

use App\Entity\Review;
use App\Enum\StatusEnum;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use Symfony\Component\Form\Extension\Core\Type\EnumType;

class ReviewCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Review::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular('Review')
            ->setEntityLabelInPlural('Reviews');
    }
    public function configureFields(string $pageName): iterable
    {
       return [
            IdField::new('id')->hideOnForm(),
            TextField::new('title'),

            TextField::new('slug')
               ->onlyOnForms(),

            TextEditorField::new('content')
                ->onlyOnForms(),

            ImageField::new('cover', 'Cover Image')
                ->setUploadDir('public/uploads/images/review')
                ->setBasePath('uploads/images/review')
                ->setRequired(false)
                ->onlyOnForms(),

            IntegerField::new('gameRating')
                ->setRequired(true),

            ChoiceField::new('status', 'Status')
                ->setFormType(EnumType::class)
                ->setFormTypeOptions(['class' => StatusEnum::class,])
                ->setChoices(StatusEnum::cases()),

           AssociationField::new('tag')
               ->setFormTypeOptions([
                   'choice_label' => 'title',
                   'multiple' => true
               ])
               ->setLabel('Tags')
               ->formatValue(fn($value) => $value ? implode('<br>', array_map(fn($tag) => $tag->getTitle(), $value->toArray())) : ''),

           AssociationField::new('game')
               ->setFormTypeOptions([
                   'choice_label' => 'title',
                   'multiple' => true
               ])
               ->setLabel('Games')
               ->formatValue(fn($value) => $value ? implode('<br>', array_map(fn($game) => $game->getTitle(), $value->toArray())) : ''),

            AssociationField::new('author')
                ->setFormTypeOptions(['choice_label' => 'nickname']),
        ];
    }
}
