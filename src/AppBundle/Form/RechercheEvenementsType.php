<?php
/**
 * Created by PhpStorm.
 * User: cyprien
 * Date: 04/02/2018
 * Time: 15:51
 */

namespace AppBundle\Form;

use AppBundle\Form\Type\DateAndTimeType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class RechercheEvenementsType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
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
            ->add('dateDebut', DateAndTimeType::class, array(
                'required' => false,
            ))
            ->add('lieu', EntityType::class, array(
                'class'    => 'AppBundle\Entity\Lieu',
                'choice_label' => 'ville',
                'placeholder' => 'Ville',
                'required' => false,
                'multiple' => false
            ))
            ->add('niveau', EntityType::class, array(
                'class'    => 'AppBundle\Entity\Niveau',
                'choice_label' => 'type',
                'placeholder' => 'Niveau',
                'required' => false,
                'multiple' => false
            ))
            ->add('categorieAge', EntityType::class, array(
                'class'    => 'AppBundle\Entity\CategorieAge',
                'choice_label' => 'type',
                'placeholder' => 'Catégorie d\'âge',
                'required' => false,
                'multiple' => false
            ))
            ->add('sport', EntityType::class, array(
                'class'    => 'AppBundle\Entity\Sport',
                'choice_label' => 'intitule',
                'placeholder' => 'Sport',
                'required' => false,
                'multiple' => false
            ));
    }
}