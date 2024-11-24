<?php

declare(strict_types=1);

namespace App\Form;

use App\Entity\Answer;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
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
                    'Interested' => 'interested',
                    'Relieved' => 'relieved',
                    'Shocked' => 'shocked',
                ],
                'expanded' => true,
                'multiple' => false,
                'label' => 'Reactions',
            ])
            ->add('health', TextType::class, [
                'label' => 'Health',
                'help' => 'Character\'s health level (0-100)',
            ])
            ->add('energy', TextType::class, [
                'label' => 'Energy',
                'help' => 'Character\'s energy level (0-100)',
            ])
            ->add('mood', TextType::class, [
                'label' => 'Mood',
                'help' => 'Character\'s mood level (0-100)',
            ])
            ->add('state', TextType::class, [
                'label' => 'State',
                'help' => 'Character\'s state (e.g., normal, tired, sick)',
            ])
            ->add('hunger', TextType::class, [
                'label' => 'Hunger',
                'help' => 'Character\'s hunger level (0-100)',
            ])
            ->add('stress', TextType::class, [
                'label' => 'Stress',
                'help' => 'Character\'s stress level (0-100)',
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Answer::class,
        ]);
    }
}
