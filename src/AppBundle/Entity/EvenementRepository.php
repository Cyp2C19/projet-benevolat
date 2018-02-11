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

class EvenementRepository extends EntityRepository
{
    public function getAllEvenements($pageCourante, $limit, $criteres)
    {
        if(isset($criteres['date']) && !is_null($criteres['date']))
        {
            $date = $criteres['date'];
        }
        else{
            $date = date('Y-m-d');
        }

        $qb = $this->createQueryBuilder('e')
            ->select('e')
            ->where('e.dateDebut >= :date')
            ->orWhere(':date between e.dateDebut and e.dateFin')
            ->orderBy('DATE_DIFF(e.dateDebut, :date)')
            ->setParameter('date', $date);

        if(isset($criteres['sport']) && !is_null($criteres['sport']))
        {
            $qb->andWhere('e.sport = :sport')
                ->setParameter('sport', $criteres['sport']);
        }
        if(isset($criteres['niveau']) && !is_null($criteres['niveau']))
        {
            $qb->andWhere('e.niveau = :niveau')
                ->setParameter('niveau', $criteres['niveau']);
        }
        if(isset($criteres['categorie']) && !is_null($criteres['categorie']))
        {
            $qb->andWhere('e.categorieAge = :categorieAge')
                ->setParameter('categorieAge', $criteres['categorie']);
        }
        if(isset($criteres['interieur']) && !is_null($criteres['interieur']))
        {
            $qb->andWhere('e.interieur = :interieur')
                ->setParameter('interieur', $criteres['interieur']);
        }
        if(isset($criteres['ville']) && !is_null($criteres['ville']))
        {
            $qb->andWhere('e.ville like :ville')
                ->setParameter('ville', $criteres['ville']->getVille());
        }
        $query = $qb->getQuery();

        $paginator = $this->paginate($query, $pageCourante, $limit);

        return $paginator;
    }

    public function paginate($dql, $page, $limit)
    {
        $paginator = new Paginator($dql);
        $paginator->getQuery()
            ->setFirstResult($limit * ($page - 1)) // Décalage
            ->setMaxResults($limit); // Limite
        return $paginator;
    }

}