<?php
/**
 * Created by PhpStorm.
 * User: cyprien
 * Date: 22/12/2017
 * Time: 16:45
 */

namespace AppBundle\Form;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\AbstractType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Doctrine\ORM\EntityRepository;

class ProfileClubFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('sportParDefaut', EntityType::class, array(
                'class'    => 'AppBundle\Entity\Sport',
                'choice_label' => 'intitule',
                'placeholder' => 'Choix d\'un sport',
                'multiple' => false,
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('s')
                        ->orderBy('s.intitule', 'ASC');
                },
                'required' => false
            ))
            ->remove('username')
            ->remove('current_password');
    }

    public function getParent()
    {
        return 'FOS\UserBundle\Form\Type\ProfileFormType';
    }

}