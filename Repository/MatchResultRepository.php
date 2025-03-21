<?php

namespace Visca\Bundle\LicomBundle\Repository;

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
            ->leftJoin('mi.matchParticipant', 'mp', 'WITH', 'mp.id = mi.matchParticipant')
            ->where('mp.match = :matchId')
            ->setParameter('matchId', $match->getId())
            ->getQuery()
            ->getSingleResult();

        return $result['total'];
    }

    /**
     * @param Match $match
     * @param int   $matchResultTypeId
     *
     * @return int
     */
    public function getTotalResultByMatchAndType(Match $match, $matchResultTypeId)
    {
        $result = $this->createQueryBuilder('matchResult')
            ->select('SUM(matchResult.value) AS total')
            ->innerJoin('matchResult.matchParticipant', 'matchParticipant')
            ->innerJoin('matchParticipant.match', 'match')
            ->where('match = :match')
            ->andWhere('matchResult.matchResultType = :matchResultTypeId')
            ->setParameter('match', $match)
            ->setParameter('matchResultTypeId', $matchResultTypeId)
            ->getQuery()
            ->getSingleResult();

        return $result['total'];
    }

    /**
     * @param Match $match
     * @param int   $matchResultTypeId
     *
     * @return array
     */
    public function findByMatchAndMatchResultType(Match $match, $matchResultTypeId)
    {
        $result = $this->createQueryBuilder('matchResult')
            ->innerJoin('matchResult.matchParticipant', 'matchParticipant')
            ->innerJoin('matchParticipant.match', 'match')
            ->where('match = :match')
            ->andWhere('matchResult.matchResultType = :matchResultTypeId')
            ->andWhere("matchResult.del = 'no'")
            ->setParameter('match', $match)
            ->setParameter('matchResultTypeId', $matchResultTypeId)
            ->getQuery()
            ->getResult();

        return $result;
    }
}
