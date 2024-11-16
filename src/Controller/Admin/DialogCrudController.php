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
            AssociationField::new('parentDialog', 'Parent Dialog')->setRequired(false),
            IntegerField::new('selectedAnswer', 'Selected Parent Answer')->setRequired(false),
            TextField::new('name', 'Dialog Name'),
            AssociationField::new('members', 'Participants')
                ->setFormTypeOptions(['by_reference' => false])
                ->setRequired(false),
            TextareaField::new('content', 'Dialog Content'),
            ChoiceField::new('emoji', 'Dialog Emoji')
                ->setChoices([
                    '😀 Smile' => '😀',
                    '😢 Cry' => '😢',
                    '😡 Angry' => '😡',
                    '😂 Laugh' => '😂',
                    '🤔 Thinking' => '🤔',
                    '😴 Sleepy' => '😴',
                    '👍 Thumbs Up' => '👍',
                    '👎 Thumbs Down' => '👎',
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
