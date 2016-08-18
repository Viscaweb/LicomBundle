<?php

namespace Visca\Bundle\LicomBundle\Repository;

use Visca\Bundle\DoctrineBundle\Repository\Abstracts\AbstractEntityRepository;

/**
 * Class BettingOfferRepository.
 */
class BettingOfferRepository extends AbstractEntityRepository
{

    /**
     * Returns all the offers from the given outcome ids
     *
     * @param array $outcomeIds
     *
     * @return array
     */
    public function findByOutcomeIds($outcomeIds = array())
    {
        if (empty($outcomeIds)) {
            return [];
        }

        $queryBuilder = $this
            ->createQueryBuilder('o')
            ->where('o.bettingOutcome IN (:outcomeIds)')
            ->setParameter('outcomeIds', $outcomeIds);

        return $queryBuilder->getQuery()->getResult();
    }

    /**
     * Returns all the offers from the given outcome ids and provider ids
     *
     * @param array $outcomeIds
     *
     * @return array
     */
    public function findByOutcomeIdsAndProviderIds($outcomeIds = array(), $providerIds = array())
    {
        if (empty($outcomeIds) || empty($providerIds)) {
            return [];
        }

        $queryBuilder = $this
            ->createQueryBuilder('o')
            ->select('*')
            ->join('o.bettingOutcome', 'bo')
            ->where('o.bettingOutcome IN (:outcomeIds)')
            ->andWhere('o.bettingOfferProvider IN (:providerIds)')
            ->setParameter('outcomeIds', $outcomeIds)
            ->setParameter('providerIds', $providerIds);

        return $queryBuilder->getQuery()->getResult();
    }

    /**
     * Returns the Providers Ids that have offers from the outcomes given, and limited by the number we want
     *
     * @param array $outcomeIds
     * @param int   $providersLimit
     *
     * @return array
     */
    public function getProviderIdsFromOutcomes($outcomeIds = array(), $providersLimit = 3)
    {
        if(empty($outcomeIds)){
            return [];
        }

        $queryBuilder = $this
            ->createQueryBuilder('o')
            ->select('bp.id')
            ->join('o.bettingOfferProvider', 'bp')
            ->where('o.bettingOutcome IN (:outcomeIds)')
            ->setParameter('outcomeIds', $outcomeIds)
            ->groupBy('bp.id')
            ->setMaxResults($providersLimit);

        $arrayResult =  $queryBuilder->getQuery()->getScalarResult();

        return array_column($arrayResult, 'id');

    }

}
