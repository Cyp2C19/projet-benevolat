<?php
/**
 * Created by PhpStorm.
 * User: cyprien
 * Date: 30/01/2018
 * Time: 16:19
 */

namespace AppBundle\Admin;
use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;
use AppBundle\Entity\Evenement;

class EvenementAdmin extends AbstractAdmin
{
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->with('Informations générales')
            ->add('titre')
            ->add('club', 'entity', [
                'label' => 'Organisateur',
                'class' => 'AppBundle\Entity\Club'
            ])
            ->add('sport', 'entity', [
                'class' => 'AppBundle\Entity\Sport',
                'choice_label' => 'intitule',
            ])
            ->add('categorieAge', 'entity', [
                'class' => 'AppBundle\Entity\CategorieAge',
                'label' => 'Catégorie d\'âge',
                'choice_label' => 'type',
            ])
            ->add('niveau', 'entity', [
                'class' => 'AppBundle\Entity\Niveau',
                'choice_label' => 'type',
            ])
            ->add('tarifPlein', 'number', [
                'invalid_message' => 'Veuillez entrer un nombre',
                'required' => false
            ])
            ->add('tarifReduit', 'number', [
                'invalid_message' => 'Veuillez entrer un nombre',
                'required' => false
            ])
            ->add('description', 'textarea', [
                'required'    => false,
            ])
            ->add('demandesBenevolat', 'entity', [
                'class'    => 'AppBundle\Entity\MissionBenevolat',
                'label' => 'Demandes de bénévolat',
                'choice_label' => 'type',
                'multiple' => true,
                'by_reference' => false,
                'required' => false
            ])
            ->end()

            ->with('Dates')
            ->add('dateDebut', 'date', [
                'label' => 'Date de début'
            ])
            ->add('dateFin', 'date', [
                'label' => 'Date de fin',
                'required' => false
            ])
            ->add('horaire', 'time', [
                'label' => 'Horaire'
            ])
            ->end()

            ->with('Lieu')
            ->add('adresse', 'text')
            ->add('ville', 'text')
            ->add('codePostal', 'text')
            ->end()
        ;
    }

    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('titre')
            ->add('sport.intitule')
            ->add('niveau.type')
            ->add('categorieAge.type');
    }

    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier('titre')
            ->add('club')
            ->add('sport.intitule')
            ->add('niveau.type')
            ->add('categorieAge.type')
            ->add('ville')
            ->add('dateDebut')
            ->add('dateFin')
            ->add('horaire');
    }

    public function toString($object)
    {
        return $object instanceof Evenement
            ? $object->getTitre()
            : 'Événement'; // shown in the breadcrumb on the create view
    }
}