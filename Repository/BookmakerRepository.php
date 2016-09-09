<?php

namespace Visca\Bundle\LicomBundle\Repository;

use Visca\Bundle\DoctrineBundle\Repository\Abstracts\AbstractEntityRepository;

/**
 * Class BookmakerRepository.
 */
class BookmakerRepository extends AbstractEntityRepository
{

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
            ->createQueryBuilder('b')
            ->select('b')
            ->andWhere('b.id in (:bookmakerKeys)')
            ->orderBy('FIELD(b.id, :bookmakerKeys)')
            ->setParameter('bookmakerKeys', $bookmakerKeys);

        return $queryBuilder->getQuery()->getResult();
    }

}
