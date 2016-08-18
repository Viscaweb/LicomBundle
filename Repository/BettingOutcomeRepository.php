<?php

namespace Visca\Bundle\LicomBundle\Repository;

use Visca\Bundle\DoctrineBundle\Repository\Abstracts\AbstractEntityRepository;
use Visca\Bundle\LicomBundle\Entity\Code\BettingOutcomeScopeTypeCode;
use Visca\Bundle\LicomBundle\Entity\Code\EntityCode;

/**
 * Class BettingOutcomeRepository.
 */
class BettingOutcomeRepository extends AbstractEntityRepository
{
    /**
     * Returns the outcomes for the ordinary time
     *
     * @param int|null $matchId
     * @param int|null $outcomeType
     *
     * @return array
     */
    public function getOrdinaryTimeOutcomeIdsByMatchIdAndType($matchId = null, $outcomeType = null)
    {
        if (is_null($matchId)  || is_null($outcomeType)) {
            return [];
        }

        $queryBuilder = $this->createQueryBuilder('o')->select('o.id');

        $queryBuilder
            ->where('o.entity = :entity')
            ->andWhere('o.entityId = :matchId')
            ->andWhere('o.scopeType = :bettingOutcomeScopeType')
            ->andWhere('o.type = :outcomeType')
            ->setParameter('entity', EntityCode::MATCH_CODE)
            ->setParameter('matchId', $matchId)
            ->setParameter('bettingOutcomeScopeType', BettingOutcomeScopeTypeCode::ORDINARY_TIME_CODE)
            ->setParameter('outcomeType', $outcomeType);

        $arrayResult =  $queryBuilder->getQuery()->getScalarResult();

        return array_column($arrayResult, 'id');
    }

}
