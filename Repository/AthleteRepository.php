<?php

namespace Visca\Bundle\LicomBundle\Repository;

use Visca\Bundle\DoctrineBundle\Repository\Abstracts\AbstractEntityRepository;

/**
 * Class AthleteRepository.
 */
class AthleteRepository extends AbstractEntityRepository
{
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
