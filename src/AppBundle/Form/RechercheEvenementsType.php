<?php
/**
 * Created by PhpStorm.
 * User: cyprien
 * Date: 04/02/2018
 * Time: 15:51
 */

namespace AppBundle\Form;

use AppBundle\Form\Type\DateAndTimeType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Doctrine\ORM\EntityRepository;
use Doctrine\Common\Persistence\ObjectManager;
use AppBundle\Form\Type\EntityToIdType;

class RechercheEvenementsType extends AbstractType
{

    protected $em;

    public function __construct(ObjectManager $em) {
        $this->em = $em;
    }
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $sport = 0;
        if(isset($options['criteres']['sport'])){
            $sport = $options['criteres']['sport']->getId();
        }
        $niveau = 0;
        if(isset($options['criteres']['niveau'])){
            $niveau = $options['criteres']['niveau']->getId();
        }
        $categorie = 0;
        if(isset($options['criteres']['categorie'])){
            $categorie = $options['criteres']['categorie']->getId();
        }
        $lieu = 0;
        if(isset($options['criteres']['lieu'])){
            $lieu = $options['criteres']['lieu']->getId();
        }
        $date = null;
        if(isset($options['criteres']['date'])){
            $date = $options['criteres']['date'];
        }
        $interieur = null;
        if(isset($options['criteres']['interieur'])){
            $interieur = $options['criteres']['interieur'];
        }

        $builder
            ->add('interieur', ChoiceType::class, array(
                'choices'  => array(
                    'Intérieur' => true,
                    'Extérieur' => false,
                ),
                'data' => $interieur,
                'expanded' => true,
                'multiple' => false,
                'required' => false,
                'placeholder' => false
            ))
            ->add('dateDebut', DateAndTimeType::class, array(
                'data_class' => null,
                'required' => false,
                'data' => $date
            ))
            ->add('lieu', EntityType::class, array(
                'class'    => 'AppBundle\Entity\Lieu',
                'choice_label' => 'ville',
                'placeholder' => 'Ville',
                'data' => $this->em->find('AppBundle\Entity\Lieu', $lieu),
                'required' => false,
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('l')
                        ->groupBy('l.ville')
                        ->orderBy('l.ville', 'ASC');
                },
                'multiple' => false
            ))
            ->add('niveau', EntityType::class, array(
                'class'    => 'AppBundle\Entity\Niveau',
                'choice_label' => 'type',
                'placeholder' => 'Niveau',
                'data' => $this->em->find('AppBundle\Entity\Niveau', $niveau),
                'required' => false,
                'multiple' => false
            ))
            ->add('categorieAge', EntityType::class, array(
                'class'    => 'AppBundle\Entity\CategorieAge',
                'choice_label' => 'type',
                'placeholder' => 'Catégorie d\'âge',
                'data' => $this->em->find('AppBundle\Entity\CategorieAge', $categorie),
                'required' => false,
                'multiple' => false
            ))
            ->add('sport', EntityType::class, array(
                'class'    => 'AppBundle\Entity\Sport',
                'choice_label' => 'intitule',
                'placeholder' => 'Sport',
                'data' => $this->em->find('AppBundle\Entity\Sport', $sport),
                'required' => false,
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('s')
                        ->orderBy('s.intitule', 'ASC');
                },
                'multiple' => false
            ));
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setRequired('criteres');
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