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
     * @param CompetitionSeason         $competitionSeason     CompetitionSeason entity
     * @param CompetitionStageType      $competitionStageType  CompetitionStageType entity
     * @param null|CompetitionStageType $competitionStageType2 CompetitionStageType entity
     *
     * @throws \Doctrine\ORM\NonUniqueResultException
     *
     * @return CompetitionRound[]
     */
    public function findByCompetitionSeasonAndCompetitionStageType(
        CompetitionSeason $competitionSeason,
        CompetitionStageType $competitionStageType,
        $competitionStageType2 = null
    ) {
        $queryBuilder = $this->entityManager->createQueryBuilder();

        $queryBuilder->select('Round')
            ->from('ViscaLicomBundle:CompetitionRound', 'Round')
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

        if($competitionStageType2 instanceof CompetitionStageType){
            $queryBuilder
                ->andWhere('Stage.competitionStageType2 = :competitionStageType2')
                ->setParameter('competitionStageType2', $competitionStageType2->getId());
        }

        return $queryBuilder->getQuery()->getResult();
    }

    /**
     * @param CompetitionSeason         $competitionSeason         CompetitionSeason entity
     * @param CompetitionStageType      $competitionStageType      CompetitionStageType entity
     * @param int                       $seasonStageGraphLabelCode CompetitionSeasonStageGraphLabelCode
     *                                                             value so we can filter by
     *                                                             `current round`|
     *                                                             `next round`|
     *                                                             `last round`|
     *                                                             `previous round`.
     * @param null|CompetitionStageType $competitionStageType2     CompetitionStageType entity
     *
     * @throws \Doctrine\ORM\NonUniqueResultException
     *
     * @return CompetitionRound[]
     */
    public function findByCompetitionSeasonAndCompetitionStageTypeAndLabel(
        CompetitionSeason $competitionSeason,
        CompetitionStageType $competitionStageType,
        $seasonStageGraphLabelCode,
        $competitionStageType2 = null
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

        if($competitionStageType2 instanceof CompetitionStageType){
            $queryBuilder
                ->andWhere('Stage.competitionStageType2 = :competitionStageType2')
                ->setParameter('competitionStageType2', $competitionStageType2->getId());
        }

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
     * @param CompetitionSeasonStage[] $competitionSeasonStages
     * @param int                      $label
     *
     * @throws \Doctrine\ORM\NonUniqueResultException
     *
     * @return mixed
     */
    public function findLabeledByCompetitionSeasonStages(
        $competitionSeasonStages,
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
                'SeasonStageGraph.competitionSeasonStage IN (:competitionSeasonStage)'
            )
            ->andWhere('SeasonStageGraph.label = :label')
            ->setParameters(
                [
                    'competitionSeasonStage' => $competitionSeasonStages,
                    'label' => $label,
                ]
            );

        return $queryBuilder->getQuery()->getResult();
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

    /**
     * @param int $months
     *
     * @return CompetitionRound[]
     */
    public function findGroupedBySeasonStageStartingWithinMonths($months)
    {
        return $this
            ->createQueryBuilder('cr')
            ->where('cr.start
                BETWEEN
                DATE_SUB(CURRENT_DATE(), :monthDiff, \'month\')
                AND
                DATE_ADD(CURRENT_DATE(), :monthDiff, \'month\')')
            ->groupBy('cr.competitionSeasonStage')
            ->setParameter('monthDiff', $months / 2)
            ->getQuery()
            ->getResult();
    }
}
