<?php

namespace AppBundle\Form;

use AppBundle\Form\Type\DateAndTimeType;
use AppBundle\Form\Type\TimerType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Valid;

class EvenementType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('titre', TextareaType::class)
            ->add('tarifPlein', NumberType::class, array(
                'invalid_message' => 'Veuillez entrer un nombre',
                'required' => false
            ))
            ->add('tarifReduit', NumberType::class, array(
                'invalid_message' => 'Veuillez entrer un nombre',
                'required' => false
            ))
            ->add('dateDebut', DateAndTimeType::class)
            ->add('dateFin', DateAndTimeType::class)
            ->add('horaire', TimerType::class)
            ->add('description', TextareaType::class)
            ->add('lieu', LieuType::class, array(
                'constraints' => array(new Valid()),
            ))
            ->add('niveau', EntityType::class, array(
                'class'    => 'AppBundle\Entity\Niveau',
                'choice_label' => 'type',
                'placeholder' => 'Choix d\'un niveau',
                'multiple' => false
            ))
            ->add('categorieAge', EntityType::class, array(
                'class'    => 'AppBundle\Entity\CategorieAge',
                'choice_label' => 'type',
                'placeholder' => 'Choix d\'une catégorie',
                'multiple' => false
            ))
            ->add('sport', EntityType::class, array(
                'class'    => 'AppBundle\Entity\Sport',
                'choice_label' => 'intitule',
                'placeholder' => 'Choix d\'un sport',
                'multiple' => false
            ))
            ->add('demandesBenevolat', EntityType::class, array(
                'class'    => 'AppBundle\Entity\MissionBenevolat',
                'label' => 'Demande de bénévolat',
                'choice_label' => 'type',
                'multiple' => true,
                'by_reference' => false,
                'required' => false
            ));
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Evenement'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'appbundle_evenement';
    }


}
