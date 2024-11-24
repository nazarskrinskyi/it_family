<?php

declare(strict_types=1);

namespace App\Controller\Admin;

use App\Entity\MainCharacter;
use App\Enum\RoleInFamily;
use App\Enum\RoleInItTeam;
use App\Form\FamilyMemberType;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\CollectionField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
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
            BooleanField::new('is_active', 'Active'),
            TextField::new('name', 'Name'),
            IntegerField::new('age', 'Age'),
            TextareaField::new('bio', 'Biography')->setRequired(false),
            CollectionField::new('hobbies', 'Hobbies')
                ->setEntryType(TextType::class)
                ->allowAdd()
                ->allowDelete(),
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
            // New fields
            IntegerField::new('health', 'Health')
                ->setHelp('Character\'s health level (0-100)'),
            IntegerField::new('energy', 'Energy')
                ->setHelp('Character\'s energy level (0-100)'),
            IntegerField::new('mood', 'Mood')
                ->setHelp('Character\'s mood level (0-100)'),
            TextField::new('state', 'State')
                ->setHelp('Character\'s state (e.g., normal, tired, sick)'),
            IntegerField::new('hunger', 'Hunger')
                ->setHelp('Character\'s hunger level (0-100)'),
            IntegerField::new('stress', 'Stress')
                ->setHelp('Character\'s stress level (0-100)'),
            CollectionField::new('familyMembers', 'Family Members')
                ->setFormType(CollectionType::class)
                ->setEntryType(FamilyMemberType::class)
                ->allowAdd()
                ->allowDelete(),
        ];
    }
}
