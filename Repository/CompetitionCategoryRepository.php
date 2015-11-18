<?php

namespace Visca\Bundle\LicomBundle\Repository;

use Visca\Bundle\DoctrineBundle\Repository\Abstracts\AbstractEntityRepository;
use Visca\Bundle\LicomBundle\Entity\CompetitionCategory;

/**
 * Class CompetitionCategoryRepository.
 */
class CompetitionCategoryRepository extends AbstractEntityRepository
{
    /**
     * @param int|null $limit Limit
     *
     * @return array
     */
    public function getAllIds($limit = null)
    {
        $queryBuilder = $this->createQueryBuilder('c')->select('c.id');

        if (isset($limit)) {
            $queryBuilder->setMaxResults($limit);
        }

        return $queryBuilder->getQuery()->getArrayResult();
    }

    /**
     * Returns all the CompetitionCategory in the array given
     *
     * @param  array|null $competitionCategoriesIds ids to search
     * @param string|null $orderBy                  Field to order by
     *
     * @return CompetitionCategory[]
     */
    public function findByIds(
        $competitionCategoriesIds = null,
        $orderBy = null
    ) {
        $queryBuilder = $this
            ->entityManager
            ->createQueryBuilder()
            ->from($this->entityName, 'cc')
            ->select('cc')
            ->where('cc.id IN (:ccIds)')
            ->setParameter('ccIds', $competitionCategoriesIds);
        if (!is_null($orderBy)) {
            $queryBuilder
                ->orderBy('cc.'.$orderBy, 'ASC');
        }

        return $queryBuilder->getQuery()->execute();
    }
}
