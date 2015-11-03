<?php

namespace Visca\Bundle\LicomBundle\Repository;

use Visca\Bundle\DoctrineBundle\Repository\Abstracts\AbstractEntityRepository;
use Visca\Bundle\LicomBundle\Entity\MatchLineupParticipant;

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
        $queryBuilder = $this->createQueryBuilder('m');
        $queryBuilder
            ->where('m.matchLineup = :matchLineupId')
            ->setParameter('matchLineupId', $matchLineupId);

        return $queryBuilder->getQuery()->getResult();
    }
}
