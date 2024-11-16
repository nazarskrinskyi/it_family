<?php

declare(strict_types=1);

namespace App\Form;

use App\Entity\Answer;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

final class AnswerType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('content', TextareaType::class, ['label' => 'Answer Content'])
            ->add('emoji', ChoiceType::class, [
                'choices' => [
                    '😀' => '😀',
                    '😢' => '😢',
                    '😡' => '😡',
                    '😂' => '😂',
                    '🤔' => '🤔',
                    '😴' => '😴',
                    '👍' => '👍',
                    '👎' => '👎',
                ],
                'label' => 'Answer Emoji',
                'placeholder' => 'Select an Emoji',
                'multiple' => false,
                'required' => false,
            ])
            ->add('reactions', ChoiceType::class, [
                'choices' => [
                    'Smile' => 'happy',
                    'Bored' => 'bored',
                    'Angry' => 'angry',
                    'Sick' => 'sick',
                    'Sad' => 'sad',
                    'excited' => 'excited',
                    'exhausted' => 'exhausted',
                ],
                'expanded' => true,
                'multiple' => false,
                'label' => 'Reactions',
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Answer::class,
        ]);
    }
}
