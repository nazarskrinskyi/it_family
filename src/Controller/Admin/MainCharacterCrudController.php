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
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;

final class MainCharacterCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return MainCharacter::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('name'),
            IntegerField::new('age'),
            ChoiceField::new('roleInFamily')
                ->setChoices(array_combine(
                    array_map(fn($role) => $role->name, RoleInFamily::cases()), // Display enum names as labels
                    RoleInFamily::cases() // Use enum cases as values
                ))
                ->setLabel('Role in Family'),

            ChoiceField::new('roleInItTeam')
                ->setChoices(array_combine(
                    array_map(fn($role) => $role->name, RoleInItTeam::cases()), // Display enum names as labels
                    RoleInItTeam::cases() // Use enum cases as values
                ))
                ->setLabel('Role in IT Team'),
            ImageField::new('image')
                ->setUploadDir('public/uploads/images')
                ->setBasePath('uploads/images')
                ->setRequired(false),
            CollectionField::new('familyMembers')
                ->setFormType(CollectionType::class)
                ->setEntryType(FamilyMemberType::class)
                ->allowAdd()
                ->allowDelete(),
        ];
    }
}
