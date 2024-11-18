<?php

declare(strict_types=1);

namespace App\Controller\Admin;

use App\Entity\MainCharacter;
use App\Enum\RoleInFamily;
use App\Enum\RoleInItTeam;
use App\Form\FamilyMemberType;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\CollectionField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

final class MainCharacterCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return MainCharacter::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('name', 'Name'),
            IntegerField::new('age', 'Age'),
            DateField::new('birthDate', 'Birth Date')->setRequired(false),
            TextField::new('bio', 'Biography')->setRequired(false),
            TextField::new('favoriteColor', 'Favorite Color')->setRequired(false),
            CollectionField::new('hobbies', 'Hobbies')
                ->setEntryType(TextType::class)
                ->allowAdd()
                ->allowDelete(),
            TextField::new('personalityType', 'Personality Type')->setRequired(false),
            ChoiceField::new('roleInFamily', 'Role in Family')
                ->setChoices(array_combine(
                    array_map(fn($role) => $role->name, RoleInFamily::cases()), // Display enum names as labels
                    RoleInFamily::cases() // Use enum cases as values
                )),
            ChoiceField::new('roleInItTeam', 'Role in IT Team')
                ->setChoices(array_combine(
                    array_map(fn($role) => $role->name, RoleInItTeam::cases()), // Display enum names as labels
                    RoleInItTeam::cases() // Use enum cases as values
                )),
            ImageField::new('image', 'Image')
                ->setUploadDir('public/uploads/images')
                ->setBasePath('uploads/images')
                ->setRequired(false),
            CollectionField::new('familyMembers', 'Family Members')
                ->setFormType(CollectionType::class)
                ->setEntryType(FamilyMemberType::class)
                ->allowAdd()
                ->allowDelete(),
        ];
    }
}
