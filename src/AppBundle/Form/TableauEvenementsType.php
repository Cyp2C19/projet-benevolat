<?php
/**
 * Created by PhpStorm.
 * User: cyprien
 * Date: 26/12/2017
 * Time: 19:57
 */

namespace AppBundle\Form;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\FormBuilderInterface;
use Doctrine\Common\Persistence\ObjectManager;

class TableauEvenementsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('evenements', CollectionType::class, array(
                'entry_type' => EvenementMinType::class,
                'entry_options' => array(
                        'label' => false,
                        'attr' => array('class' => 'item')),
                'allow_delete' => true,
                'allow_add'    => true,
                'prototype' => true,
                'by_reference' => false,
                'attr' => array(
                    'class' => 'table selection_evenements highlight responsive-table',
                ),
            ));
    }

    public function getBlockPrefix()
    {
        return 'TableauEvenementsType';
    }

    /**
     * @return ObjectManager
     */
    public function getEm()
    {
        return $this->em;
    }

    /**
     * @param ObjectManager $em
     */
    public function setEm($em)
    {
        $this->em = $em;
    }


}