<?php
/**
 * Created by PhpStorm.
 * User: cyprien
 * Date: 27/12/2017
 * Time: 16:13
 */

namespace AppBundle\Form\Type;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Form\DataTransformerInterface;

class EntityToIdType implements DataTransformerInterface
{
    /**
     * EntityManager pour récupérer nos entités
     */
    private $manager;
    /**
     * Le nom de la class que l'on passe dans le constructor
     */
    private $class;

    public function __construct(ObjectManager $manager, $class) {
        $this->manager = $manager;
        $this->class = $class;
    }

    /**
     * Transforme l'entité passé à la méthode en retournant son ID
     * Return String/Integer
     */
    public function transform($entity) {
        if (null === $entity) {
            return '';
        }
        return $entity->getId();
    }

    /**
     * On passe l'ID pour retourner l'entité
     * Return Entity
     */
    public function reverseTransform($value) {
        if (!$value) {
            return;
        }
        // Recherche de l'entité corespondante
        $entity = $this->manager
            ->getRepository($this->class)
            ->find($value);
        return $entity;
    }
}