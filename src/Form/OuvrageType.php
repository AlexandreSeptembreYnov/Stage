<?php

namespace App\Form;

use App\Entity\Auteur;
use App\Entity\Ouvrage;
use App\Entity\Theme;
use App\Repository\OuvrageRepository;
use App\Repository\ThemeRepository;
use Doctrine\ORM\Mapping\Entity;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class OuvrageType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('Numero')
            ->add('Titre')
            ->add('ThemeId', EntityType::class, array(
                'class' => Theme::class,
                'choice_label' => 'libelle',
                'attr' => array('class' => 'form-control'),
            ))
            ->add('AuteurId', EntityType::class, array(
                'class' => Auteur::class,
                'choice_label' => 'libelle',
                'attr' => array('class' => 'form-control'),
            ));
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Ouvrage::class,
        ]);
    }
}