<?php

namespace App\Controller\Admin;

use App\Entity\User;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class UserCrudController extends AbstractCrudController
{
    public function __construct(
        private UserPasswordHasherInterface $passwordHasher,
        private ValidatorInterface $validator
    ) {
    }

    public static function getEntityFqcn(): string
    {
        return User::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular('User')
            ->setEntityLabelInPlural('Users');
    }

    public function configureFields(string $pageName): iterable
    {
        $fields = [
            IdField::new('id')->hideOnForm(),
            TextField::new('nickname'),
            TextField::new('email'),

            TextField::new('password')
                ->setFormType(PasswordType::class)
                ->setRequired(true)
                ->onlyOnForms(),

            ChoiceField::new('roles')
                ->setChoices([
                    'Admin' => 'ROLE_ADMIN',
                    'User' => 'ROLE_USER',
                ])
                ->setFormTypeOptions([
                    'multiple' => true,
                    'expanded' => true,
                ]),

            TextField::new('twitchAccount')
                ->setRequired(false)
                ->onlyOnForms(),

            ImageField::new('avatar', 'Avatar')
                ->setUploadDir('public/uploads/images/user')
                ->setBasePath('uploads/images/user')
                ->setRequired(false)
                ->onlyOnForms(),
        ];

        if ($pageName === Crud::PAGE_EDIT) {
            $fields[] = TextField::new('password')
                ->setFormType(PasswordType::class)
                ->setRequired(false)
                ->setHelp('Leave empty to keep current password');
        }

        return $fields;
    }


    public function persistEntity(EntityManagerInterface $entityManager, $entityInstance): void
    {
        if ($entityInstance instanceof User) {
            // Проверка на уникальность email
            $errors = $this->validator->validate($entityInstance);

            foreach ($errors as $error) {
                if ($error->getMessage() === 'This email is already registered.') {
                    // Если email уже существует, добавляем сообщение об ошибке
                    $this->addFlash('error', $error->getMessage());
                    // Прерываем выполнение метода, не сохраняем пользователя
                    return;
                }
            }

            // Если email уникален, продолжаем сохранять
            if ($entityInstance->getPassword()) {
                $hashedPassword = $this->passwordHasher->hashPassword($entityInstance, $entityInstance->getPassword());
                $entityInstance->setPassword($hashedPassword);
            }

            $roles = $entityInstance->getRoles();
            if (in_array('ROLE_ADMIN', $roles)) {
                $roles = array_diff($roles, ['ROLE_ADMIN']);
                array_unshift($roles, 'ROLE_ADMIN');
            }

            $entityInstance->setRoles($roles);
        }

        parent::persistEntity($entityManager, $entityInstance);
    }



    public function updateEntity(EntityManagerInterface $entityManager, $entityInstance): void
    {
        if ($entityInstance instanceof User) {
            $currentUser = $entityManager->getRepository(User::class)->find($entityInstance->getId());

            if (!$entityInstance->getPassword()) {
                $entityInstance->setPassword($currentUser->getPassword());
            } else {
                $entityInstance->setPassword(
                    $this->passwordHasher->hashPassword($entityInstance, $entityInstance->getPassword())
                );
            }
        }

        parent::updateEntity($entityManager, $entityInstance);
    }
}