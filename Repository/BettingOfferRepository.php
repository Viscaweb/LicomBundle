<?php

namespace Visca\Bundle\LicomBundle\Repository;

use Visca\Bundle\DoctrineBundle\Repository\Abstracts\AbstractEntityRepository;

/**
 * Class BettingOfferRepository.
 */
class BettingOfferRepository extends AbstractEntityRepository
{

    /**
     * Retuns all the offers from the given outcome ids
     *
     * @param array $outcomeIds
     *
     * @return array
     */
    public function findByOutcomeIds($outcomeIds = array()){

        if(empty($outcomeIds)){
            return [];
        }

        $queryBuilder = $this->createQueryBuilder('o');

        $queryBuilder
            ->where('o.bettingOutcome IN (:outcomeIds)')
            ->setParameter('outcomeIds', $outcomeIds);

        return $queryBuilder->getQuery()->getResult();
    }

}
