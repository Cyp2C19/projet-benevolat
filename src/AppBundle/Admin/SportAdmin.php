<?php
/**
 * Created by PhpStorm.
 * User: cyprien
 * Date: 30/01/2018
 * Time: 14:49
 */

namespace AppBundle\Admin;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;
use AppBundle\Entity\Sport;

class SportAdmin extends AbstractAdmin
{
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->add('intitule')
            ->add('logo', 'file', [
                'data_class' => null,
                'label' => 'Logo sport (Taille conseillée : 128 x 128 pixels)',
                'required' => false
            ]);
    }

    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper->add('intitule');
    }

    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper->addIdentifier('intitule');
    }

    public function toString($object)
    {
        return $object instanceof Sport
            ? $object->getIntitule()
            : 'Sport'; // shown in the breadcrumb on the create view
    }
}