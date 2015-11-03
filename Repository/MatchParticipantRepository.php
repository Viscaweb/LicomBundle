<?php

namespace Visca\Bundle\LicomBundle\Repository;

use Visca\Bundle\DoctrineBundle\Repository\Abstracts\AbstractEntityRepository;
use Visca\Bundle\LicomBundle\Entity\MatchParticipant;

/**
 * Class MatchRepository.
 */
class MatchParticipantRepository extends AbstractEntityRepository
{
    /**
     * @param int $participantId
     *
     * @return MatchParticipant[]
     */
    public function findById($participantId)
    {
        return $this
            ->createQueryBuilder('m')
            ->where('m.id = :participantId')
            ->setParameter('participantId', $participantId)
            ->getQuery()
            ->getResult();
    }
}
