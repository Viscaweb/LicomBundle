<?php

namespace Visca\Bundle\LicomBundle\Repository;

use Visca\Bundle\DoctrineBundle\Repository\Abstracts\AbstractEntityRepository;
use Visca\Bundle\LicomBundle\Entity\StandingColumn;
use Visca\Bundle\LicomBundle\Entity\StandingRow;

/**
 * Class StandingCellRepository.
 */
class StandingCellRepository extends AbstractEntityRepository
{
    /**
     * @param StandingRow    $row    Row
     * @param StandingColumn $column Column
     *
     * @return array
     */
    public function findByRowColumn(StandingRow $row, StandingColumn $column)
    {
        return $this
            ->entityManager
            ->createQueryBuilder()
            ->select('c')
            ->from('StandingCell', 'c')
            ->where('standingRow = :row')
            ->andWhere('standingColumn = :column')
            ->setParameter('row', $row)
            ->setParameter('column', $column)
            ->getQuery()
            ->getResult();
    }
}
