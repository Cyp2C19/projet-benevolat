<?php
/**
 * Created by PhpStorm.
 * User: cyprien
 * Date: 26/12/2017
 * Time: 19:57
 */

namespace AppBundle\Form;
use AppBundle\Form\Type\DateAndTimeType;
use AppBundle\Form\Type\EntityToIdType;
use AppBundle\Form\Type\TimerType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Doctrine\Common\Persistence\ObjectManager;

class EvenementMinType extends AbstractType
{

    protected $em;

    public function __construct(ObjectManager $em) {
        $this->em = $em;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('titre', TextType::class, array(
                'label' => false
            ))
            ->add('dateDebut', DateAndTimeType::class, array(
                'label' => false
            ))
            ->add('dateFin', DateAndTimeType::class, array(
                'label' => false,
                'required' => false
            ))
            ->add('horaire', TimerType::class, array(
                'label' => false
            ))
            ->add('description', TextType::class, array(
                'label' => false,
                'required' => false
            ))
            ->add('tarifPlein', HiddenType::class)
            ->add('tarifReduit', HiddenType::class)
            ->add('interieur', HiddenType::class)
            ->add('niveau', HiddenType::class)
            ->add('categorieAge', HiddenType::class)
            ->add('adresse', HiddenType::class)
            ->add('ville', HiddenType::class)
            ->add('codePostal', HiddenType::class)
            ->add('club', HiddenType::class)
            ->add('sport', HiddenType::class)
            ->add('id', HiddenType::class);
            // Ajout des DataTransformer pour passer des id aux objets et inversement
            $builder ->get('niveau')->addModelTransformer(new EntityToIdType($this->em, 'AppBundle\Entity\Niveau'));
            $builder ->get('categorieAge')->addModelTransformer(new EntityToIdType($this->em, 'AppBundle\Entity\CategorieAge'));
            $builder->get('club')->addModelTransformer(new EntityToIdType($this->em, 'AppBundle\Entity\Club'));
            $builder->get('sport')->addModelTransformer(new EntityToIdType($this->em, 'AppBundle\Entity\Sport'));
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Evenement'
        ));
    }

    public function getBlockPrefix()
    {
        return 'EvenementMinType';
    }
}