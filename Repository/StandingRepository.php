<?php

namespace Visca\Bundle\LicomBundle\Repository;

use Doctrine\ORM\Mapping\ClassMetadata;
use Visca\Bundle\DoctrineBundle\Repository\Abstracts\AbstractEntityRepository;
use Visca\Bundle\LicomBundle\Entity\Standing;

/**
 * Class StandingRepository.
 */
class StandingRepository extends AbstractEntityRepository
{
    /**
     * @param int $entity         Entity
     * @param int $entityId       Entity Id
     * @param int $standingViewId The StandingView id used to filter columns
     *
     * @return Standing
     *
     * @throws \Doctrine\ORM\NoResultException
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function findByView($entity, $entityId, $standingViewId)
    {
        return $this
            ->createQueryBuilder('standing')
            ->join('standing.standingRow', 'row')
            ->leftJoin('row.standingCell', 'cell')
            ->join('cell.standingColumn', 'column')
            ->join('column.standingViewGraph', 'view_graph')
            ->join('view_graph.standingView', 'view')
            ->andWhere('standing.entity = :entity')
            ->andWhere('standing.entityId = :entityId')
            ->andWhere('view_graph.standingView = :standingViewId')
            ->setParameters(
                [
                    'entity' => $entity,
                    'entityId' => $entityId,
                    'standingViewId' => $standingViewId,
                ]
            )
            ->getQuery()
            ->setFetchMode(
                'ViscaLicomBundle:Standing',
                'standingRow',
                ClassMetadata::FETCH_EAGER
            )
            ->getOneOrNullResult();
    }
}
