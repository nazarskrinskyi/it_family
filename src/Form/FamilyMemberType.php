<?php

declare(strict_types=1);

namespace App\Form;

use App\Entity\FamilyMember;
use App\Enum\RoleInFamily;
use App\Enum\RoleInItTeam;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
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
            ->add('image', FileType::class, [
                'label' => 'Image',
                'required' => false,
                'mapped' => false,
                'help' => 'Upload an image if desired.',
            ])
            ->add('roleInFamily', ChoiceType::class, [
                'choices' => array_combine(
                    array_map(fn(RoleInFamily $role) => $role->name, RoleInFamily::cases()),
                    RoleInFamily::cases()
                ),
                'choice_label' => fn(?RoleInFamily $role) => $role?->name,
                'choice_value' => fn(?RoleInFamily $role) => $role?->value,
                'expanded' => false,
                'multiple' => false,
                'label' => 'Role in Family',
            ])
            ->add('roleInItTeam', ChoiceType::class, [
                'choices' => array_combine(
                    array_map(fn(RoleInItTeam $role) => $role->name, RoleInItTeam::cases()),
                    RoleInItTeam::cases()
                ),
                'choice_label' => fn(?RoleInItTeam $role) => $role?->name,
                'choice_value' => fn(?RoleInItTeam $role) => $role?->value,
                'expanded' => false,
                'multiple' => false,
                'label' => 'Role in IT Team',
            ])
            ->add('birthDate', DateType::class, [
                'widget' => 'single_text',
                'required' => false,
                'label' => 'Birth Date',
            ])
            ->add('bio', TextareaType::class, [
                'required' => false,
                'label' => 'Biography',
            ])
            ->add('favoriteColor', TextType::class, [
                'required' => false,
                'label' => 'Favorite Color',
            ])
            ->add('hobbies', CollectionType::class, [
                'entry_type' => TextType::class,
                'allow_add' => true,
                'allow_delete' => true,
                'required' => false,
                'label' => 'Hobbies',
            ])
            ->add('personalityType', TextType::class, [
                'required' => false,
                'label' => 'Personality Type',
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