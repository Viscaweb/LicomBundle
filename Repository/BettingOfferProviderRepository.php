<?php

namespace Visca\Bundle\LicomBundle\Repository;

use Doctrine\ORM\Query\Expr\Join;
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
            ->select('p, partial bm.{id}')
            ->join('p.bookmakers', 'bm')
            ->andWhere('bm.id in (:bookmakerKeys)')
            ->orderBy('FIELD(bm.id, :bookmakerKeys)')
            ->setParameter('bookmakerKeys', $bookmakerKeys);

        return $queryBuilder->getQuery()->getResult();
    }

    /**
     * Returns all the offers from the given outcome ids and provider ids.
     *
     * @param array $outcomeIds
     * @param array $bookmakerKeys
     *
     * @return array
     */
    public function findProviderByOutcomeAndBookmakerKeys($outcomeIds = [], $bookmakerKeys = [])
    {
        if (empty($outcomeIds) || empty($bookmakerKeys)) {
            return [];
        }

        $queryBuilder = $this
            ->createQueryBuilder('p')
            ->select('p, b, o')
            ->join('p.bettingOffers', 'o')
            ->join('p.bookmakers', 'b')
            ->where('o.bettingOutcome IN (:outcomeIds)')
            ->andWhere('b.id IN (:bookmakerKeys)')
            ->andWhere('o.del = \'no\'')
            ->setParameter('outcomeIds', $outcomeIds)
            ->setParameter('bookmakerKeys', $bookmakerKeys)
            ->orderBy('FIELD(b.id, :bookmakerKeys)');

        return $queryBuilder->getQuery()->getResult();
    }
}
