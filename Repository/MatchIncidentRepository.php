<?php

namespace Visca\Bundle\LicomBundle\Repository;

use Visca\Bundle\DoctrineBundle\Repository\Abstracts\AbstractEntityRepository;
use Visca\Bundle\LicomBundle\Entity\MatchIncidentType;
use Visca\Bundle\LicomBundle\Entity\MatchParticipant;

/**
 * Class MatchIncidentRepository.
 */
class MatchIncidentRepository extends AbstractEntityRepository
{
    /**
     * @param MatchParticipant    $matchParticipant MatchParticipant
     * @param MatchIncidentType[] $typeList         MatchIncidentType[]
     *
     * @return array
     */
    public function findByMatchParticipantAndTypeList(
        MatchParticipant $matchParticipant,
        $typeList
    ) {
        $queryBuilder = $this
            ->createQueryBuilder('m');

        return $queryBuilder
            ->from('ViscaLicomBundle:MatchIncident', 'm')
            ->where('m.matchParticipant = :matchParticipant')
            ->andWhere(
                $queryBuilder->expr()->in('m.matchIncidentType', $typeList)
            )
            ->setParameter('matchParticipant', $matchParticipant)
            ->getQuery()
            ->getResult();
    }

    /**
     * @param int|null $limit Limit
     *
     * @return array
     */
    public function getAllIds($limit = null)
    {
        $queryBuilder = $this->createQueryBuilder('m')->select('m.id');

        if (isset($limit)) {
            $queryBuilder->setMaxResults($limit);
        }

        return $queryBuilder->getQuery()->getArrayResult();
    }
}
