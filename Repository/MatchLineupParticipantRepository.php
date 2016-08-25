<?php

namespace Visca\Bundle\LicomBundle\Repository;

use Doctrine\ORM\Query\Expr\Join;
use Visca\Bundle\DoctrineBundle\Repository\Abstracts\AbstractEntityRepository;
use Visca\Bundle\LicomBundle\Entity\MatchLineupParticipant;
use Visca\Bundle\LicomBundle\Entity\MatchParticipant;

/**
 * Class MatchLineupRepository.
 */
class MatchLineupParticipantRepository extends AbstractEntityRepository
{
    /**
     * Get MatchLineup by MatchLineup.
     *
     * @param int $matchLineupId MatchLineup ID.
     *
     * @return MatchLineupParticipant[]
     */
    public function findByMatchLineup($matchLineupId)
    {
        $queryBuilder = $this->createQueryBuilder('ml');
        $queryBuilder
            ->select('ml', 'p', 'px')
            ->where('ml.matchLineup = :matchLineupId')
            ->leftJoin('ml.participant', 'p')
            ->leftJoin('p.aux', 'px')
            ->setParameter('matchLineupId', $matchLineupId);

        return $queryBuilder->getQuery()->getResult();
    }

    /**
     * Get MatchLineup by MatchLineup. Preloads MatchIncidents
     * Sorted by MatchLineup.position.
     *
     * @param int              $matchLineupId    MatchLineup ID.
     * @param MatchParticipant $matchParticipant
     *
     * @return \Visca\Bundle\LicomBundle\Entity\MatchLineupParticipant[]
     */
    public function findByMatchLineupWithIncidents($matchLineupId, MatchParticipant $matchParticipant)
    {
        $queryBuilder = $this->createQueryBuilder('ml');
        $queryBuilder
            ->select('ml', 'mlt', 'p', 'px', 'mi')
            ->where('ml.matchLineup = :matchLineupId')
            ->leftJoin('ml.matchLineupType', 'mlt')
            ->leftJoin('ml.participant', 'p')
            ->leftJoin('p.aux', 'px')
            ->leftJoin('p.matchIncident', 'mi', Join::WITH, 'mi.matchParticipant = :matchParticipant')
            ->setParameters([
                'matchLineupId' => $matchLineupId,
                'matchParticipant' => $matchParticipant
            ])
            ->orderBy('ml.position', 'ASC');

        return $queryBuilder->getQuery()->getResult();
    }
}
