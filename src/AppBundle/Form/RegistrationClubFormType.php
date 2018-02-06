<?php
/**
 * Created by PhpStorm.
 * User: cyprien
 * Date: 19/12/2017
 * Time: 11:24
 */

namespace AppBundle\Form;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\AbstractType;
use Doctrine\ORM\EntityRepository;

class RegistrationClubFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('intitule', EntityType::class, array(
                'class'    => 'AppBundle\Entity\NomClub',
                'choice_label' => 'nom',
                'placeholder' => 'Choix d\'un club',
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('c')
                        ->orderBy('c.nom', 'ASC');
                },
                'multiple' => false
            ))
            ->add('sportParDefaut', EntityType::class, array(
                'class'    => 'AppBundle\Entity\Sport',
                'choice_label' => 'intitule',
                'placeholder' => 'Choix d\'un sport',
                'required' => false,
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('s')
                        ->orderBy('s.intitule', 'ASC');
                },
                'multiple' => false
            ))
            ->remove('username');
    }
    public function getParent()
    {
        return 'FOS\UserBundle\Form\Type\RegistrationFormType';
    }
}