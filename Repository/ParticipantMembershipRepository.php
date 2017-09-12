<?php

namespace Visca\Bundle\LicomBundle\Repository;

use Visca\Bundle\DoctrineBundle\Repository\Abstracts\AbstractEntityRepository;
use Visca\Bundle\LicomBundle\Entity\Athlete;
use Visca\Bundle\LicomBundle\Entity\Code\EntityCode;
use Visca\Bundle\LicomBundle\Entity\Participant;

/**
 * Class ParticipantMembershipRepository.
 */
class ParticipantMembershipRepository extends AbstractEntityRepository
{
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
            ->setParameter('entityId', EntityCode::COMPETITION_SEASON_CODE)
            ->getQuery()
            ->getArrayResult();
    }

    /**
     * @param Athlete $athlete Athlete
     *
     * @return array
     */
    public function getArrayParticipantIdsByAthlete(
        Athlete $athlete
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
            ->Where('pm.active = true')
            ->orderBy('pm.start', 'DESC')
            ->setParameter('participantId', $athlete->getId())
            ->setParameter('entityId', EntityCode::PARTICIPANT_CODE)
            ->getQuery()
            ->getArrayResult();
    }

    /**
     * @param int $athleteId AthleteId
     *
     * @return array
     */
    public function getParticipantIdsByAthleteId($athleteId)
    {
        return $this
            ->createQueryBuilder('pm')
            ->select('pm')
            ->join(
                'pm.participant',
                'participant',
                'WITH',
                'participant.id = :participantId'
            )
            ->join('pm.entity', 'entity', 'WITH', 'entity.id = :entityId')
            ->andWhere('pm.active = true')
            ->setParameter('participantId', $athleteId)
            ->setParameter('entityId', EntityCode::PARTICIPANT_CODE)
            ->getQuery()
            ->getArrayResult();
    }

    /**
     * @param Participant $participant
     * @param $matchDate
     * @return mixed
     */
    public function findTeamCoachActiveByParticipantAndDate(Participant $participant, $matchDate)
    {
        return $this
            ->createQueryBuilder('pm')
            ->where('(pm.entity = :entity AND pm.entityId = :participantId AND pm.active = true AND pm.start >= :matchDate AND pm.participantType = \'coach\')')
            ->where('(pm.entity = :entity AND pm.entityId = :participantId AND pm.start >= :matchDate AND pm.end <= :matchDate AND pm.participantType = \'coach\')')
            ->setParameter('participantId', $participant->getId())
            ->setParameter('matchDate', $matchDate)
            ->setParameter('entity', EntityCode::PARTICIPANT_CODE)
            ->getQuery()
            ->getOneOrNullResult();
    }
}
