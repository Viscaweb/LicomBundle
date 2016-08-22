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
     * @param array $providerIds
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
            ->where('o.bettingOutcome IN (:outcomeIds)')
            ->andWhere('o.bettingOfferProvider IN (:providerIds)')
            ->setParameter('outcomeIds', $outcomeIds)
            ->setParameter('providerIds', $providerIds);

        return $queryBuilder->getQuery()->getResult();
    }
}
