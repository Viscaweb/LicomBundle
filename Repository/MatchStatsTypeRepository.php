<?php

namespace Visca\Bundle\LicomBundle\Repository;

use Visca\Bundle\DoctrineBundle\Repository\Abstracts\AbstractEntityRepository;
use Visca\Bundle\LicomBundle\Entity\Match;

/**
 * Class MatchRepository.
 */
class MatchStatsTypeRepository extends AbstractEntityRepository
{
    /**
     * @param int $matchStatsTypeId
     *
     * @return Match[]
     */
    public function findById($matchStatsTypeId)
    {
        return $this
            ->createQueryBuilder('m')
            ->where('m.id = :matchStatsTypeId')
            ->setParameter('matchStatsTypeId', $matchStatsTypeId)
            ->getQuery()
            ->getResult();
    }
}
