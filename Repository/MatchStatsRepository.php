<?php

namespace Visca\Bundle\LicomBundle\Repository;

use Visca\Bundle\DoctrineBundle\Repository\Abstracts\AbstractEntityRepository;
use Visca\Bundle\LicomBundle\Entity\Match;
use Visca\Bundle\LicomBundle\Entity\MatchStats;

/**
 * Class MatchStatsRepository.
 */
class MatchStatsRepository extends AbstractEntityRepository
{
    /**
     * @param Match $match The Match object
     *
     * @return MatchStats[]
     */
    public function findByMatch(Match $match)
    {
        return $this
            ->createQueryBuilder('match_stats')
            ->select('match_stats', 'match_participant', 'mt')
            ->join('match_stats.matchParticipant', 'match_participant')
            ->join('match_stats.matchStatsType', 'mt')
            ->where('match_participant.match = :matchId')
            ->setParameter('matchId', $match->getId())
            ->getQuery()
            ->getResult();
    }
}
