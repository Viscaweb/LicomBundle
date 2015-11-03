<?php

namespace Visca\Bundle\LicomBundle\Repository;

use Visca\Bundle\DoctrineBundle\Repository\Abstracts\AbstractEntityRepository;
use Visca\Bundle\LicomBundle\Entity\MatchStatusDescription;
use Visca\Bundle\LicomBundle\Repository\Traits\GetAndSortByIdTrait;

/**
 * Class MatchStatusDescriptionRepository.
 */
class MatchStatusDescriptionRepository extends AbstractEntityRepository
{
    use GetAndSortByIdTrait;

    /**
     * @param int|null $limit Limit
     *
     * @return array
     */
    public function getAllIds($limit = null)
    {
        $queryBuilder = $this->createQueryBuilder('m')->select('m.id');

        if (isset($limit)) {
            $queryBuilder->setMaxResults($limit);
        }

        return $queryBuilder->getQuery()->getArrayResult();
    }

    /**
     * @return null|MatchStatusDescription
     */
    public function findHalfTimeEntity()
    {
        return $this->findOneBy(['code' => 'Halftime']);
    }

    /**
     * @return null|MatchStatusDescription
     */
    public function findFinishedEntity()
    {
        return $this->findOneBy(['code' => 'Finished']);
    }
}
