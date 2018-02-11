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
use AppBundle\Entity\NomClub;

class NomClubAdmin extends AbstractAdmin
{
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper->add('nom');
    }

    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('nom');
    }

    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier('nom');
    }

    public function toString($object)
    {
        return $object instanceof NomClub
            ? $object->getNom()
            : 'Intitulé de club'; // shown in the breadcrumb on the create view
    }
}