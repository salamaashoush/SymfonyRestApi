<?php

namespace AppBundle\Repository;

/**
 * UserRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class UserRepository extends \Doctrine\ORM\EntityRepository
{
    public function findAllQuery($sort = null,$order = null,$start = 0,$end = 10)
    {
        $qb = $this->getEntityManager()->createQueryBuilder();
        $qb->select('u')
            ->from('AppBundle:User', 'u');
        if ($sort && $order) {
            $qb->orderBy('u.' . $sort, $order);
        }
        $query = $qb->getQuery();
        $query->setFirstResult($start)
            ->setMaxResults($end);
        return $query;
    }
}
