<?php

namespace AppBundle\Form;

use AppBundle\Form\Type\DateAndTimeType;
use AppBundle\Form\Type\TimerType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Doctrine\ORM\EntityRepository;

class EvenementType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $sport = $options['sport'];

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
            ->add('interieur', ChoiceType::class, array(
                'choices'  => array(
                    'Intérieur' => true,
                    'Extérieur' => false,
                ),
                'expanded' => true,
                'multiple' => false,
                'required' => false,
                'placeholder' => false
            ))
            ->add('dateDebut', DateAndTimeType::class)
            ->add('dateFin', DateAndTimeType::class)
            ->add('horaire', TimerType::class)
            ->add('description', TextareaType::class, array(
                'required'    => false,
            ))
            ->add('adresse', TextType::class, array(
                'required' => false,
            ))
            ->add('ville', TextType::class, array(
                'required' => false,
            ))
            ->add('codePostal', TextType::class, array(
                'required' => false
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
                'data' => $sport,
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('s')
                        ->orderBy('s.intitule', 'ASC');
                },
                'multiple' => false
            ))
            ->add('demandesBenevolat', EntityType::class, array(
                'class'    => 'AppBundle\Entity\MissionBenevolat',
                'label' => 'Demandes de bénévolat',
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
        $resolver->setRequired('sport');
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'appbundle_evenement';
    }
}
