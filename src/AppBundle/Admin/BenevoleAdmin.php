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
use AppBundle\Entity\Benevole;

class BenevoleAdmin extends AbstractAdmin
{
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper->add('username');
    }

    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper->add('username');
    }

    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper->addIdentifier('username');
    }

    public function toString($object)
    {
        return $object instanceof Benevole
            ? $object->getEmail()
            : 'Bénévole'; // shown in the breadcrumb on the create view
    }
}