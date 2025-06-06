<?php

namespace App\Controller\Admin;

use App\Entity\Developer;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use Symfony\Component\Yaml\Yaml;

class DeveloperCrudController extends AbstractCrudController
{
    private array $countries;
    public function __construct()
    {
        $yamlData = Yaml::parseFile(__DIR__ . '/../../../config/countries.yaml');
        $this->countries = array_column($yamlData['countries'], 'name', 'name');
    }
    public static function getEntityFqcn(): string
    {
        return Developer::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular('Developer')
            ->setEntityLabelInPlural('Developers');
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->hideOnForm(),
            TextField::new('title'),

            TextField::new('slug')
                ->onlyOnForms(),

            ChoiceField::new('country')
                ->setChoices($this->countries)
                ->setRequired(false)
                ->renderAsNativeWidget(false),

            TextField::new('website'),
        ];
    }
}
