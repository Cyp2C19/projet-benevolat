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
        $formMapper
            ->add('email')
            ->add('plainPassword', 'password', array(
                'label' => 'Mot de passe'))
            ->add('enabled', 'choice', array(
                'label' => 'Activation email',
                'choices' => array('Activé' => true, 'Non activé' => false),
            ))
            ->add('nom')
            ->add('prenom')
            ->add('telephone')
            ->add('dateNaissance', 'date',[
                'years' => range(date('1920'), date('Y'))
            ]);
    }

    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('email')
            ->add('nom')
            ->add('prenom');
    }

    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier('email')
            ->add('nom')
            ->add('prenom')
            ->add('telephone');
    }

    public function toString($object)
    {
        return $object instanceof Benevole
            ? $object->getEmail()
            : 'Bénévole'; // shown in the breadcrumb on the create view
    }
}