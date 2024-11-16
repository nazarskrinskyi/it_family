<?php

declare(strict_types=1);

namespace App\Form;

use App\Entity\FamilyMember;
use App\Enum\RoleInFamily;
use App\Enum\RoleInItTeam;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\OptionsResolver\OptionsResolver;

final class FamilyMemberType extends AbstractType
{
    public function __construct(private string $uploadDir)
    {
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, ['label' => 'Name'])
            ->add('age', IntegerType::class, ['label' => 'Age'])
            ->add('roleInFamily', ChoiceType::class, [
                'choices' => RoleInFamily::cases(),
                'choice_label' => function (?RoleInFamily $role) {
                    return $role?->name; // Display the enum case name
                },
                'choice_value' => function (?RoleInFamily $role) {
                    return $role?->value; // Map enum to its value
                },
                'expanded' => false,  // Use dropdown
                'multiple' => false,  // Don't allow multiple choices
            ])
            ->add('roleInItTeam', ChoiceType::class, [
                'choices' => RoleInItTeam::cases(),
                'choice_label' => function (?RoleInItTeam $role) {
                    return $role?->name; // Display the enum case name
                },
                'choice_value' => function (?RoleInItTeam $role) {
                    return $role?->value; // Map enum to its value
                },
                'expanded' => false,  // Use dropdown
                'multiple' => false,  // Don't allow multiple choices
            ]);

        $builder->addEventListener(FormEvents::PRE_SET_DATA, function (FormEvent $event) {
            $entity = $event->getData();

            $event->getForm()
                ->add('image', FileType::class, [
                'label' => 'Image',
                'required' => false,
                'mapped' => false,
                'help' => $entity && $entity->getImage()
                    ? sprintf('Current file: %s', $entity->getImage())
                    : 'No image uploaded',
            ]);
        });

        $builder->addEventListener(FormEvents::POST_SUBMIT, function (FormEvent $event) {
            $form = $event->getForm();
            $entity = $event->getData();

            /** @var UploadedFile $uploadedFile */
            $uploadedFile = $form->get('image')->getData();

            if ($uploadedFile) {
                $newFilename = uniqid().'.'.$uploadedFile->guessExtension();

                $uploadedFile->move($this->uploadDir, $newFilename);

                $entity->setImage($newFilename);
            }
        });
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => FamilyMember::class,
        ]);
    }
}