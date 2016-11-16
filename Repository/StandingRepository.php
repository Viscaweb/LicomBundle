<?php

namespace Visca\Bundle\LicomBundle\Repository;

use Doctrine\ORM\Mapping\ClassMetadata;
use Visca\Bundle\DoctrineBundle\Repository\Abstracts\AbstractEntityRepository;
use Visca\Bundle\LicomBundle\Entity\Code\StandingColumnCode;
use Visca\Bundle\LicomBundle\Entity\Code\StandingTypeCode;
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
     * @throws \Doctrine\ORM\NoResultException
     * @throws \Doctrine\ORM\NonUniqueResultException
     *
     * @return Standing
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

    /**
     * @param string $entity
     * @param int    $entityId
     *
     * @return bool
     */
    public function hasCompetitionLiveStandingUpToDateData($entity, $entityId)
    {
        $totalMatchesPlayed = $this
            ->createQueryBuilder('standing')
            ->select('SUM(cell.value)')
            ->join('standing.standingRow', 'row')
            ->join('row.standingCell', 'cell', 'WITH', 'cell.standingColumn = :matchesTotalCode')
            ->andWhere('standing.entity = :entity')
            ->andWhere('standing.entityId = :entityId')
            ->andWhere('standing.standingType in (:leagueTableCode, :liveLeagueTableCode)')
            ->groupBy('standing.standingType')
            ->setParameters(
                [
                    'matchesTotalCode' => StandingColumnCode::MATCHES_TOTAL_CODE,
                    'liveLeagueTableCode' => StandingTypeCode::LIVE_LEAGUE_TABLE_CODE,
                    'leagueTableCode' => StandingTypeCode::LEAGUE_TABLE_CODE,
                    'entity' => $entity,
                    'entityId' => $entityId,
                ]
            )
            ->getQuery()
            ->getArrayResult();

        if (empty($totalMatchesPlayed) || !isset($totalMatchesPlayed[0][1], $totalMatchesPlayed[1][1])) {
            return false;
        }

        return (int)$totalMatchesPlayed[1][1] - (int)$totalMatchesPlayed[0][1] != 0;
    }
}
