<?php
/**
 * Created by PhpStorm.
 * User: cyprien
 * Date: 30/01/2018
 * Time: 15:04
 */

namespace AppBundle\Admin;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;
use AppBundle\Entity\Niveau;

class NiveauAdmin extends AbstractAdmin
{
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper->add('type');
    }

    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper->add('type');
    }

    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper->addIdentifier('type');
    }

    public function toString($object)
    {
        return $object instanceof Niveau
            ? $object->getType()
            : 'Niveau'; // shown in the breadcrumb on the create view
    }
}