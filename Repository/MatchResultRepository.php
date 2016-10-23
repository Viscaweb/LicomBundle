<?php

namespace Visca\Bundle\LicomBundle\Repository;

use Doctrine\ORM\Query\Expr\Join;
use Visca\Bundle\DoctrineBundle\Repository\Abstracts\AbstractEntityRepository;
use Visca\Bundle\LicomBundle\Entity\Match;

/**
 * Class MatchResultRepository.
 *
 * @package Visca\Bundle\LicomBundle\Repository
 */
class MatchResultRepository extends AbstractEntityRepository
{
    /**
     * @param Match $match Match entity
     *
     * @return int
     */
    public function countByMatch(Match $match)
    {
        $result = $this->createQueryBuilder('mi')
            ->select('COUNT(mi) as total')
            ->leftJoin('mi.matchParticipant', 'mp', 'WITH', 'mp.id = mi.matchParticipant AND mp.match = :matchId')
            ->setParameter('matchId', $match->getId())
            ->getQuery()
            ->getSingleResult();

        return $result['total'];
    }
}
