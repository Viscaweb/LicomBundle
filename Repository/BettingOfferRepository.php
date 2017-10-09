<?php

namespace Visca\Bundle\LicomBundle\Repository;

use Doctrine\ORM\Query\Expr\Join;
use Visca\Bundle\DoctrineBundle\Repository\Abstracts\AbstractEntityRepository;
use Visca\Bundle\LicomBundle\Entity\BettingOffer;

/**
 * Class BettingOfferRepository.
 */
class BettingOfferRepository extends AbstractEntityRepository
{
    /**
     * Returns all the offers from the given outcome ids.
     *
     * @param array $outcomeIds
     *
     * @return array
     */
    public function findByOutcomeIds($outcomeIds = [])
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
     * Returns all the offers from the given outcome ids and provider ids.
     *
     * @param array $outcomeIds
     * @param array $providerIds
     *
     * @return array
     */
    public function findByOutcomeIdsAndProviderIds($outcomeIds = [], $providerIds = [])
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

    /**
     * Returns all the offers from the given outcome ids and provider ids.
     *
     * @param array $outcomeIds
     * @param array $bookmakerKeys
     * @param int   $bookmakersLimit
     *
     * @return array
     */
    public function findByOutcomeIdsAndBookmakerKeys($outcomeIds = [], $bookmakerKeys = [], $bookmakersLimit = 3)
    {
        if (empty($outcomeIds) || empty($bookmakerKeys)) {
            return [];
        }

        $queryBuilder = $this
            ->createQueryBuilder('o')
            ->join('o.bettingOfferProvider', 'p')
            ->join(
                'ViscaLicomBundle:Bookmaker',
                'b',
                Join::WITH,
                'b.provider = p.id'
            )
            ->where('o.bettingOutcome IN (:outcomeIds)')
            ->andWhere('b.id IN (:bookmakerKeys)')
            ->setParameter('outcomeIds', $outcomeIds)
            ->setParameter('bookmakerKeys', $bookmakerKeys)
            ->setMaxResults($bookmakersLimit);

        return $queryBuilder->getQuery()->getResult();
    }

    /**
     * @param int $matchId
     *
     * @return BettingOffer[]
     */
    public function findByMatch($matchId)
    {
        $queryBuilder = $this
            ->createQueryBuilder('offer')
            ->join('offer.bettingOutcome', 'outcome')
            ->where('outcome.entityId = :matchId')
            ->andWhere('outcome.entity = :matchEntity')
            ->setParameter('matchId', $matchId)
            ->setParameter('matchEntity', EntityCode::MATCH_CODE);

        return $queryBuilder->getQuery()->getResult();
    }
}
