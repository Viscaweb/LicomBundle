<?php

namespace Visca\Bundle\LicomBundle\Repository;

use Visca\Bundle\DoctrineBundle\Repository\Abstracts\AbstractEntityRepository;

/**
 * Class BettingOfferProviderRepository.
 */
class BettingOfferProviderRepository extends AbstractEntityRepository
{
    /**
     * Returns the Providers Ids that have offers from the outcomes given, and limited by the number we want.
     *
     * @param array $outcomeIds
     * @param int   $providersLimit
     *
     * @return array
     */
    public function findIdsFromOutcomes($outcomeIds = [], $providersLimit = 3)
    {
        if (empty($outcomeIds)) {
            return [];
        }

        $queryBuilder = $this
            ->createQueryBuilder('p')
            ->select('p.id')
            ->join('p.bettingOffers', 'o')
            ->where('o.bettingOutcome IN (:outcomeIds)')
            ->setParameter('outcomeIds', $outcomeIds)
            ->groupBy('p.id')
            ->setMaxResults($providersLimit);

        $arrayResult = $queryBuilder->getQuery()->getScalarResult();

        return array_column($arrayResult, 'id');
    }

    /**
     * Returns all the Partners that follows  keys available.
     *
     * @param array $bookmakerKeys
     *
     * @return array
     */
    public function findByBookmakerKeys($bookmakerKeys = [])
    {
        $queryBuilder = $this
            ->createQueryBuilder('p')
            ->select('p')
            ->join('p.bookmakers', 'bm')
            ->andWhere('bm.id in (:bookmakerKeys)')
            ->setParameter('bookmakerKeys', $bookmakerKeys);

        return $queryBuilder->getQuery()->getResult();
    }
}
