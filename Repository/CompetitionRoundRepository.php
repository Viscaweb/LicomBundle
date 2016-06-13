<?php

namespace Visca\Bundle\LicomBundle\Repository;

use Doctrine\ORM\Query\Expr\Join;
use Visca\Bundle\DoctrineBundle\Repository\Abstracts\AbstractEntityRepository;
use Visca\Bundle\LicomBundle\Entity\Code\CompetitionSeasonStageGraphLabelCode;
use Visca\Bundle\LicomBundle\Entity\CompetitionRound;
use Visca\Bundle\LicomBundle\Entity\CompetitionSeason;
use Visca\Bundle\LicomBundle\Entity\CompetitionSeasonStage;
use Visca\Bundle\LicomBundle\Entity\CompetitionStageType;

/**
 * Class CompetitionRepository.
 */
class CompetitionRoundRepository extends AbstractEntityRepository
{

    /**
     * @param CompetitionSeason    $competitionSeason         CompetitionSeason entity
     * @param CompetitionStageType $competitionStageType      CompetitionStageType entity
     *
     * @return CompetitionRound[]
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function findByCompetitionSeasonAndCompetitionStageType(
        CompetitionSeason $competitionSeason,
        CompetitionStageType $competitionStageType
    ) {
        $queryBuilder = $this->entityManager->createQueryBuilder();

        $queryBuilder->select('Round')
            ->from('ViscaLicomBundle:CompetitionRound', 'Round')
//            ->join(
//                'ViscaLicomBundle:CompetitionSeasonStageGraph',
//                'SeasonStageGraph',
//                Join::INNER_JOIN,
//                'SeasonStageGraph.competitionRound = Round.id'
//            )
            ->join(
                'ViscaLicomBundle:CompetitionSeasonStage',
                'SeasonStage',
                Join::WITH,
                'Round.competitionSeasonStage = SeasonStage.id'
            )
            ->join(
                'ViscaLicomBundle:CompetitionStage',
                'Stage',
                Join::WITH,
                'SeasonStage.competitionStage = Stage.id'
            )
            ->where('Stage.competitionStageType1 = :competitionStageType')
            ->andWhere('SeasonStage.competitionSeason = :competitionSeason')
            ->orderBy('Round.start', 'ASC');

        $parameters = [
            'competitionStageType' => $competitionStageType->getId(),
            'competitionSeason' => $competitionSeason->getId(),
        ];

        $queryBuilder->setParameters($parameters);

        return $queryBuilder->getQuery()->getResult();
    }

    /**
     * @param CompetitionSeason    $competitionSeason         CompetitionSeason entity
     * @param CompetitionStageType $competitionStageType      CompetitionStageType entity
     * @param int                  $seasonStageGraphLabelCode CompetitionSeasonStageGraphLabelCode
     *                                                        value so we can filter by
     *                                                        `current round`|
     *                                                        `next round`|
     *                                                        `last round`|
     *                                                        `previous round`.
     *
     * @return CompetitionRound[]
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function findByCompetitionSeasonAndCompetitionStageTypeAndLabel(
        CompetitionSeason $competitionSeason,
        CompetitionStageType $competitionStageType,
        $seasonStageGraphLabelCode
    ) {
        $queryBuilder = $this->entityManager->createQueryBuilder();

        $queryBuilder->select('Round')
            ->from('ViscaLicomBundle:CompetitionRound', 'Round')
            ->join(
                'ViscaLicomBundle:CompetitionSeasonStageGraph',
                'SeasonStageGraph',
                Join::WITH,
                'SeasonStageGraph.competitionRound = Round.id'
            )
            ->join(
                'ViscaLicomBundle:CompetitionSeasonStage',
                'SeasonStage',
                Join::WITH,
                'SeasonStageGraph.competitionSeasonStage = SeasonStage.id'
            )
            ->join(
                'ViscaLicomBundle:CompetitionStage',
                'Stage',
                Join::WITH,
                'SeasonStage.competitionStage = Stage.id'
            )
            ->where('Stage.competitionStageType1 = :competitionStageType')
            ->andWhere('SeasonStage.competitionSeason = :competitionSeason');

        $parameters = [
            'competitionStageType' => $competitionStageType->getId(),
            'competitionSeason' => $competitionSeason->getId(),
        ];


        $queryBuilder->andWhere('SeasonStageGraph.label = :label');
        $parameters['label'] = $seasonStageGraphLabelCode;


        $queryBuilder->setParameters($parameters);

        return $queryBuilder->getQuery()->getResult();
    }



    /**
     * Finds the current CompetitionRound by a given CompetitionSeasonStage.
     *
     * @param CompetitionSeasonStage $competitionSeasonStage
     *
     * @return CompetitionRound
     */
    public function findCurrentByCompetitionSeasonStage(
        CompetitionSeasonStage $competitionSeasonStage
    ) {
        // Get current CompetitionSeasonStage
        $queryBuilder = $this->entityManager->createQueryBuilder();

        $queryBuilder->select('Round')
            ->from('ViscaLicomBundle:CompetitionRound', 'Round')
            ->join(
                'ViscaLicomBundle:CompetitionSeasonStageGraph',
                'SeasonStageGraph',
                Join::WITH,
                'SeasonStageGraph.competitionRound = Round.id'
            )
            ->where(
                'SeasonStageGraph.competitionSeasonStage = :competitionSeasonStage'
            )
            ->andWhere('SeasonStageGraph.label = :label')
            ->setParameters(
                [
                    'competitionSeasonStage' => $competitionSeasonStage,
                    'label' => CompetitionSeasonStageGraphLabelCode::CURRENT_CODE,
                ]
            );

        return $queryBuilder->getQuery()->getOneOrNullResult();
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

    /**
     * @param CompetitionSeasonStage $competitionSeasonStage
     * @param                        $label
     *
     * @return mixed
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function findLabeledByCompetitionSeasonStage(
        CompetitionSeasonStage $competitionSeasonStage,
        $label
    ) {
        // Get current CompetitionSeasonStage
        $queryBuilder = $this->entityManager->createQueryBuilder();

        $queryBuilder->select('Round')
            ->from('ViscaLicomBundle:CompetitionRound', 'Round')
            ->join(
                'ViscaLicomBundle:CompetitionSeasonStageGraph',
                'SeasonStageGraph',
                Join::WITH,
                'SeasonStageGraph.competitionRound = Round.id'
            )
            ->where(
                'SeasonStageGraph.competitionSeasonStage = :competitionSeasonStage'
            )
            ->andWhere('SeasonStageGraph.label = :label')
            ->setParameters(
                [
                    'competitionSeasonStage' => $competitionSeasonStage,
                    'label' => $label,
                ]
            );

        return $queryBuilder->getQuery()->getOneOrNullResult();
    }

    /**
     * @return CompetitionRound[]
     */
    public function findGroupedByCompetitionSeasonStage()
    {
        return $this
            ->createQueryBuilder('cr')
            ->groupBy('cr.competitionSeasonStage')
            ->getQuery()
            ->getResult();
    }
}
