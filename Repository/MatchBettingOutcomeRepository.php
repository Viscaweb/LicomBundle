<?php

namespace Visca\Bundle\LicomBundle\Repository;

use Visca\Bundle\DoctrineBundle\Repository\Abstracts\AbstractEntityRepository;
use Visca\Bundle\LicomBundle\Entity\MatchBettingOutcome;

/**
 * Class MatchBettingOutcomeRepository.
 */
class MatchBettingOutcomeRepository extends AbstractEntityRepository
{
    /**
     * @param int   $matchId
     * @param array $types   Array of classes
     *
     * @return MatchBettingOutcome[]
     */
    public function findByMatchAndType($matchId, $types)
    {
        $instanceOf = [];
        foreach ($types as $classType) {
            $instanceOf[] = 'outcome INSTANCE OF '.$classType;
        }

        $queryBuilder = $this->entityManager
            ->createQueryBuilder();

        return $queryBuilder
            ->select('outcome')
            ->from('ViscaLicomBundle:MatchBettingOutcome', 'outcome')
            ->where(
                call_user_func_array(
                    [$queryBuilder->expr(), 'orx'],
                    $instanceOf
                )
            )
            ->andWhere('outcome.match = :matchId')
            ->setParameter('matchId', $matchId)
            ->getQuery()
            ->getResult();
    }
}
