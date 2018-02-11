<?php
/**
 * Created by PhpStorm.
 * User: cyprien
 * Date: 31/01/2018
 * Time: 09:05
 */

namespace AppBundle\Admin;
use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;
use AppBundle\Entity\Club;

class ClubAdmin extends AbstractAdmin
{
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->add('email')
            ->add('intitule', 'entity', array(
                'class'    => 'AppBundle\Entity\NomClub',
                'choice_label' => 'nom',
                'placeholder' => 'Choix d\'un club',
                'multiple' => false
            ))
            ->add('sportParDefaut', 'entity', array(
                'class'    => 'AppBundle\Entity\Sport',
                'choice_label' => 'intitule',
                'placeholder' => 'Choix d\'un sport',
                'required' => false,
                'multiple' => false
            ))
            ->add('plainPassword', 'password', array(
                'label' => 'Mot de passe'))
            ->add('enabled', 'choice', array(
                'label' => 'Activation email',
                'choices' => array('Activé' => true, 'Non activé' => false),
            ));
    }

    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('email')
            ->add('intitule.nom');
    }

    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier('email')
            ->add('intitule.nom')
            ->add('sportParDefaut.intitule');
    }

    public function toString($object)
    {
        return $object instanceof Club
            ? $object->getIntitule()->getNom()
            : 'Club'; // shown in the breadcrumb on the create view
    }
}