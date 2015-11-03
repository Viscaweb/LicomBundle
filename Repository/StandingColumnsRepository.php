<?php

namespace Visca\Bundle\LicomBundle\Repository;

use Visca\Bundle\DoctrineBundle\Repository\Abstracts\AbstractEntityRepository;
use Visca\Bundle\LicomBundle\Entity\StandingColumn;
use Visca\Bundle\LicomBundle\Entity\StandingView;

/**
 * Class StandingColumnsRepository.
 */
class StandingColumnsRepository extends AbstractEntityRepository
{
    /**
     * @param StandingView $standingView
     *
     * @return StandingColumn|null
     */
    public function findSortedByStandingView(StandingView $standingView)
    {
        return $this
            ->createQueryBuilder('column')
            ->join('column.standingViewGraph', 'graph')
            ->join('graph.label', 'label')
            ->andWhere('graph.standingView = :standingView')
            ->andWhere('label.code = :display')
            ->orderBy('graph.position', 'ASC')
            ->setParameters(
                [
                    'standingView' => $standingView,
                    'display' => 'SortRows',
                ]
            )
            ->getQuery()
            ->getOneOrNullResult();
    }

    /**
     * @param StandingView $standingView
     *
     * @return StandingColumn[]
     */
    public function findDisplayedByStandingView(StandingView $standingView)
    {
        return $this
            ->createQueryBuilder('column')
            ->join('column.standingViewGraph', 'graph')
            ->join('graph.label', 'label')
            ->andWhere('graph.standingView = :standingView')
            ->andWhere('label.code = :display')
            ->orderBy('graph.position', 'ASC')
            ->setParameters(
                [
                    'standingView' => $standingView,
                    'display' => 'Display',
                ]
            )
            ->getQuery()
            ->getResult();
    }
}
