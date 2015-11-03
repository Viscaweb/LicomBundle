<?php

namespace Visca\Bundle\LicomBundle\Repository;

use Doctrine\ORM\Query\Expr\Join;
use Visca\Bundle\DoctrineBundle\Repository\Abstracts\AbstractEntityRepository;
use Visca\Bundle\LicomBundle\Entity\Code\CompetitionSeasonStageGraphLabelCode;
use Visca\Bundle\LicomBundle\Entity\CompetitionRound;
use Visca\Bundle\LicomBundle\Entity\CompetitionSeason;
use Visca\Bundle\LicomBundle\Entity\CompetitionSeasonStage;
use Visca\Bundle\LicomBundle\Entity\CompetitionStageType;
use Visca\Bundle\LicomBundle\Repository\Traits\GetAndSortByIdTrait;

/**
 * Class CompetitionRepository.
 */
class CompetitionRoundRepository extends AbstractEntityRepository
{
    use GetAndSortByIdTrait;

    /**
     * @param CompetitionSeason    $competitionSeason         CompetitionSeason entity
     * @param CompetitionStageType $competitionStageType      CompetitionStageType entity
     * @param null|int             $seasonStageGraphLabelCode CompetitionSeasonStageGraphLabelCode
     *                                                        value so we can filter by
     *                                                        `current round`|
     *                                                        `next round`|
     *                                                        `last round`|
     *                                                        `previous round`.
     *
     * @return CompetitionRound[]
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function findByCompetitionSeasonAndCompetitionStageType(
        CompetitionSeason $competitionSeason,
        CompetitionStageType $competitionStageType,
        $seasonStageGraphLabelCode = null
    ) {
        $queryBuilder = $this->entityManager->createQueryBuilder();

        $queryBuilder->select('Round')
            ->from('ViscaLicomBundle:CompetitionRound', 'Round')
            ->join(
                'ViscaLicomBundle:CompetitionSeasonStageGraph',
                'SeasonStageGraph',
                Join::INNER_JOIN,
                'SeasonStageGraph.competitionRound = Round.id'
            )
            ->join(
                'ViscaLicomBundle:CompetitionSeasonStage',
                'SeasonStage',
                Join::INNER_JOIN,
                'SeasonStageGraph.competitionSeasonStage = SeasonStage.id'
            )
            ->join(
                'ViscaLicomBundle:CompetitionStage',
                'Stage',
                Join::INNER_JOIN,
                'SeasonStage.competitionStage = Stage.id'
            )
            ->where('Stage.competitionStageType1 = :competitionStageType')
            ->andWhere('SeasonStage.competitionSeason = :competitionSeason');

        $parameters = [
            'competitionStageType' => $competitionStageType->getId(),
            'competitionSeason' => $competitionSeason->getId(),
        ];

        if ($seasonStageGraphLabelCode !== null) {
            $queryBuilder->andWhere('SeasonStageGraph.label = :label');
            $parameters['label'] = $seasonStageGraphLabelCode;
        }

        $queryBuilder->setParameters($parameters);

        return $queryBuilder->getQuery()->getResult();
    }

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
}