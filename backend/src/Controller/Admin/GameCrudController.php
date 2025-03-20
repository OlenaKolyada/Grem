<?php

namespace App\Controller\Admin;

use App\Entity\Game;
use App\Enum\AgeRatingEnum;
use App\Enum\PlatformRequirementsLevelEnum;
use App\Enum\StatusEnum;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\ArrayField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use Symfony\Component\Form\Extension\Core\Type\EnumType;

class GameCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Game::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular('Game')
            ->setEntityLabelInPlural('Games');
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

            TextEditorField::new('summary')
                ->onlyOnForms(),

            DateField::new('releaseDateWorld', 'Release Date World')
                ->setFormTypeOption('widget', 'single_text'),

            DateField::new('releaseDateFrance', 'Release Date France')
                ->setFormTypeOption('widget', 'single_text')
                ->onlyOnForms(),

            ChoiceField::new('platformRequirementsLevel', 'Platform Requirements Level')
                ->setFormType(EnumType::class)
                ->setFormTypeOptions(['class' => PlatformRequirementsLevelEnum::class,])
                ->setChoices(PlatformRequirementsLevelEnum::cases())
                ->onlyOnForms(),

            ChoiceField::new('ageRating', 'Age Rating')
                ->setFormType(EnumType::class)
                ->setFormTypeOptions(['class' => AgeRatingEnum::class,])
                ->setChoices(AgeRatingEnum::cases()),

            ImageField::new('cover', 'Cover Image')
                ->setUploadDir('public/uploads/images/game')
                ->setBasePath('uploads/images/game')
                ->setUploadedFileNamePattern('{id}-[randomhash].[extension]')
                ->setRequired(false)
                ->setUploadedFileNamePattern('{id}-cover.[extension]')
                ->onlyOnForms(),

            ArrayField::new('language', 'Languages')
                ->onlyOnForms(),

            TextField::new('screenshot', 'Screenshots')
                ->onlyOnForms(),

            TextField::new('trailer', 'Trailer')
                ->onlyOnForms(),

            ChoiceField::new('status', 'Status')
                ->setFormType(EnumType::class)
                ->setFormTypeOptions(['class' => StatusEnum::class,])
                ->setChoices(StatusEnum::cases()),

            AssociationField::new('developer', 'Developers')
                ->setFormTypeOptions([
                    'choice_label' => 'title',
                    'multiple' => true
                ])
                ->formatValue(fn($value) => $value ? implode('<br>', array_map(fn($developer) => $developer->getTitle(), $value->toArray())) : ''),

            AssociationField::new('publisher', 'Publishers')
                ->setFormTypeOptions([
                    'choice_label' => 'title',
                    'multiple' => true
                ])
                ->formatValue(fn($value) => $value ? implode('<br>', array_map(fn($publisher) => $publisher->getTitle(), $value->toArray())) : ''),

            AssociationField::new('genre', 'Genres')
                ->setFormTypeOptions([
                    'choice_label' => 'title',
                    'multiple' => true
                ])
                ->formatValue(fn($value) => $value ? implode('<br>', array_map(fn($genre) => $genre->getTitle(), $value->toArray())) : ''),

            AssociationField::new('platform', 'Platforms')
                ->setFormTypeOptions([
                    'choice_label' => 'title',
                    'multiple' => true
                ])
                ->formatValue(fn($value) => $value ? implode('<br>', array_map(fn($platform) => $platform->getTitle(), $value->toArray())) : ''),
        ];
    }
}
