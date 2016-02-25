<?php

namespace Visca\Bundle\LicomBundle\Repository;

use Doctrine\ORM\Query\Expr\Join;
use Visca\Bundle\DoctrineBundle\Repository\Abstracts\AbstractEntityRepository;
use Visca\Bundle\LicomBundle\Entity\Match;
use Visca\Bundle\LicomBundle\Entity\MatchIncident;
use Visca\Bundle\LicomBundle\Entity\MatchIncidentType;
use Visca\Bundle\LicomBundle\Entity\MatchParticipant;

/**
 * Class MatchIncidentRepository.
 */
class MatchIncidentRepository extends AbstractEntityRepository
{
    /**
     * Gets the incidents of a match, eager loading usual related entities.
     *
     * @param Match $match              Match entity
     * @param int[] $matchIncidentTypes MatchIncidentTypes if we want to filter
     *                                  the incidents to retrieve by its type.
     *
     * @return \Visca\Bundle\LicomBundle\Entity\MatchIncident[]
     */
    public function findByMatch(Match $match, $matchIncidentTypes = array())
    {
        $queryBuilder = $this->createQueryBuilder('mi');

        $queryBuilder
            ->select('mi', 'aux', 'mp', 'p')
            ->leftJoin('mi.matchIncidentAux', 'aux')
            ->join('mi.matchParticipant', 'mp')
            ->leftJoin('mi.participant', 'p')
            ->join('mp.match', 'm', Join::WITH, 'm.id = :matchId')
            ->setParameters(
                [
                    'matchId' => $match->getId()
                ]
            );

        if (count($matchIncidentTypes) > 0) {
            $queryBuilder
                ->setParameter('matchIncidentType', $matchIncidentTypes)
                ->where('mi.matchIncidentType IN (:matchIncidentType)');
        }

        $queryBuilder
            ->orderBy('mi.time', 'ASC')
            ->addOrderBy('mi.position', 'ASC');

        return $queryBuilder->getQuery()->getResult();
    }

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
