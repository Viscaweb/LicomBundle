<?php

namespace Visca\Bundle\LicomBundle\Repository;

use Visca\Bundle\DoctrineBundle\Repository\Abstracts\AbstractEntityRepository;
use Visca\Bundle\LicomBundle\Repository\Traits\GetAndSortByIdTrait;

/**
 * Class AthleteRepository.
 */
class AthleteRepository extends AbstractEntityRepository
{
    use GetAndSortByIdTrait;

    /**
     * @return array
     */
    public function getAllIds()
    {
        return $this
            ->createQueryBuilder('a')
            ->getQuery()
            ->getArrayResult();
    }
}
