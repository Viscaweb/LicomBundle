<?php

namespace Visca\Bundle\LicomBundle\Repository;

use Visca\Bundle\DoctrineBundle\Repository\Abstracts\AbstractEntityRepository;
use Visca\Bundle\LicomBundle\Entity\MatchLineup;

/**
 * Class MatchLineupRepository.
 */
class MatchLineupRepository extends AbstractEntityRepository
{
    /**
     * Get MatchLineup by MatchParticipant.
     *
     * @param int $matchParticipantId MatchParticipant ID
     *
     * @return MatchLineup
     */
    public function findByMatchParticipant($matchParticipantId)
    {
        $queryBuilder = $this
            ->createQueryBuilder('m')
            ->where('m.matchParticipant = :matchParticipantId')
            ->setParameter('matchParticipantId', $matchParticipantId);

        return $queryBuilder->getQuery()->getOneOrNullResult();
    }

    /**
     * Get MatchLineup by MatchParticipants.
     *
     * @param int[] $matchParticipantId MatchParticipant ID
     *
     * @return MatchLineup[]
     */
    public function findByMatchParticipants($matchParticipantIds)
    {
        $queryBuilder = $this
            ->createQueryBuilder('m')
            ->where('m.matchParticipant in (:matchParticipantIds)')
            ->setParameter('matchParticipantIds', $matchParticipantIds)
            ->orderBy('m.matchParticipant');


        return $queryBuilder->getQuery()->getResult();
    }
}
