<?php

namespace Visca\Bundle\LicomBundle\Repository;

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
     * @param string $entityId
     * @param string $standingType
     *
     * @return bool
     */
    public function hasCompetitionLiveStandingUpToDateData($entity, $entityId)
    {
        $hasDifferences = $this
            ->createQueryBuilder('mainStanding')
            ->select('SUM(liveCell.value) - SUM(mainCell.value)')
            ->join('mainStanding.standingRow', 'mainRow')
            ->join('mainRow.standingCell', 'mainCell', 'WITH', 'mainCell.standingColumn = :matchesTotalCode')
            ->join(
                Standing::class, 'liveStanding', 'WITH',
                'liveStanding.entity = :entity and liveStanding.entityId = :entityId and liveStanding.standingType = :liveLeagueTableCode'
            )
            ->join('liveStanding.standingRow', 'liveRow')
            ->join('liveRow.standingCell', 'liveCell', 'WITH', 'liveCell.standingColumn = :matchesTotalCode')
            ->andWhere('mainStanding.entity = :entity')
            ->andWhere('mainStanding.entityId = :entityId')
            ->andWhere('mainStanding.standingType = :leagueTableCode')
            ->setParameters([
                'matchesTotalCode' => StandingColumnCode::MATCHES_TOTAL_CODE,
                'liveLeagueTableCode' => StandingTypeCode::LIVE_LEAGUE_TABLE_CODE,
                'leagueTableCode' => StandingTypeCode::LEAGUE_TABLE_CODE,
                'entity' => $entity,
                'entityId' => $entityId
            ])
            ->getQuery()
            ->getScalarResult();

        return empty($hasDifferences[0]) ? false : (int) $hasDifferences[0][1] > 0;
    }
}
