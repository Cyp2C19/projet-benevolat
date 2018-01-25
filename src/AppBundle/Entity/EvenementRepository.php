<?php
/**
 * Created by PhpStorm.
 * User: cyprien
 * Date: 23/01/2018
 * Time: 16:05
 */

namespace AppBundle\Entity;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Tools\Pagination\Paginator;
use InvalidArgumentException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class EvenementRepository extends EntityRepository
{
    public function getAllEvenements($pageCourante, $limit)
    {
        $qb = $this->createQueryBuilder('e')
            ->having('DATE_DIFF(e.dateDebut, CURRENT_DATE()) >= 0')
            ->orderBy('DATE_DIFF(e.dateDebut, CURRENT_DATE())');

        $query = $qb->getQuery();
        $paginator = $this->paginate($query, $pageCourante, $limit);

        return $paginator;
    }

    public function paginate($dql, $page, $limit)
    {
        $paginator = new Paginator($dql);

        $paginator->getQuery()
            ->setFirstResult($limit * ($page - 1)) // Offset
            ->setMaxResults($limit); // Limit

        return $paginator;
    }
}