<?php

namespace Visca\Bundle\LicomBundle\Repository;

use Visca\Bundle\DoctrineBundle\Repository\Abstracts\AbstractEntityRepository;
use Visca\Bundle\LicomBundle\Entity\Participant;

/**
 * Class ParticipantMembershipRepository.
 */
class ParticipantMembershipRepository extends AbstractEntityRepository
{
    const COMPETITION_SEASON_ID = 505;

    /**
     * @param Participant $participant Participant
     *
     * @return array
     */
    public function getArrayCompetitionSeasonIdsByParticipant(
        Participant $participant
    ) {
        return $this
            ->createQueryBuilder('pm')
            ->select('pm.entityId')
            ->join(
                'pm.participant',
                'participant',
                'WITH',
                'participant.id = :participantId'
            )
            ->join('pm.entity', 'entity', 'WITH', 'entity.id = :entityId')
            ->setParameter('participantId', $participant->getId())
            ->setParameter('entityId', self::COMPETITION_SEASON_ID)
            ->getQuery()
            ->getArrayResult();
    }
}
