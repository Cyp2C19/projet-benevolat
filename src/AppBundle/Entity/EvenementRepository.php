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
    public function getAllEvenements($pageCourante, $limit, $form)
    {
        if(!is_null($form['dateDebut']->getData()))
        {
            $date = $form['dateDebut']->getData();
        }
        else{
            $date = date('Y-m-d H:i:s');
        }

        $qb = $this->createQueryBuilder('e')
            ->where('e.dateDebut >= :date')
            ->orWhere(':date between e.dateDebut and e.dateFin')
            ->orderBy('DATE_DIFF(e.dateDebut, :date)')
            ->setParameter('date', $date);

        if(!is_null($form['sport']->getData()))
        {
            $qb->andWhere('e.sport = :sport')
                ->setParameter('sport', $form['sport']->getData());
        }
        if(!is_null($form['niveau']->getData()))
        {
            $qb->andWhere('e.niveau = :niveau')
                ->setParameter('niveau', $form['niveau']->getData());
        }
        if(!is_null($form['categorieAge']->getData()))
        {
            $qb->andWhere('e.categorieAge = :categorieAge')
                ->setParameter('categorieAge', $form['categorieAge']->getData());
        }
        if(!is_null($form['interieur']->getData()))
        {
            $qb->andWhere('e.interieur = :interieur')
                ->setParameter('interieur', $form['interieur']->getData());
        }
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