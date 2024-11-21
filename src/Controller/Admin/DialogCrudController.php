<?php

declare(strict_types=1);

namespace App\Controller\Admin;

use App\Entity\Dialog;
use App\Form\AnswerType;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\CollectionField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;

final class DialogCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Dialog::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            AssociationField::new('members', 'Participants'),
            TextField::new('name', 'Dialog Name')
                ->setFormTypeOptions(['by_reference' => false])
                ->setRequired(false),
            AssociationField::new('parentDialog', 'Parent Dialog')->setRequired(false),
            IntegerField::new('selectedAnswer', 'Selected Parent Answer')->setRequired(false),
            TextareaField::new('content', 'Dialog Content'),
            ChoiceField::new('emoji', 'Dialog Emoji')
                ->setChoices([
                    '😀' => '😀',
                    '😢' => '😢',
                    '😡' => '😡',
                    '😂' => '😂',
                    '🤔' => '🤔',
                    '😴' => '😴',
                    '👍' => '👍',
                    '👎' => '👎',
                ])
                ->allowMultipleChoices(false),
            ChoiceField::new('reactions', 'Reaction')
                ->setChoices([
                    'Smile' => 'happy',
                    'Bored' => 'bored',
                    'Angry' => 'angry',
                    'Sick' => 'sick',
                    'Sad' => 'sad',
                    'excited' => 'excited',
                    'exhausted' => 'exhausted',
                    'Interested' => 'interested',
                    'Relieved' => 'relieved',
                    'Shocked' => 'shocked',
                ])
                ->allowMultipleChoices(false),
            ImageField::new('image', 'Background Image')
                ->setUploadDir('public/uploads/dialogs')
                ->setBasePath('uploads/dialogs'),
            CollectionField::new('answers', 'Answers')
                ->setEntryType(AnswerType::class)
                ->allowAdd()
                ->allowDelete(),
        ];
    }
}
