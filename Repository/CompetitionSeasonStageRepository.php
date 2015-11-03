<?php

namespace Visca\Bundle\LicomBundle\Repository;

use Doctrine\ORM\Query\Expr\Join;
use Visca\Bundle\DoctrineBundle\Repository\Abstracts\AbstractEntityRepository;
use Visca\Bundle\LicomBundle\Entity\Code\CompetitionGraphLabelCode;
use Visca\Bundle\LicomBundle\Entity\Code\CompetitionSeasonGraphLabelCode;
use Visca\Bundle\LicomBundle\Entity\Code\EntityCode;
use Visca\Bundle\LicomBundle\Entity\Code\StandingTypeCode;
use Visca\Bundle\LicomBundle\Entity\Competition;
use Visca\Bundle\LicomBundle\Entity\CompetitionSeason;
use Visca\Bundle\LicomBundle\Entity\CompetitionSeasonStage;
use Visca\Bundle\LicomBundle\Entity\CompetitionStageType;
use Visca\Bundle\LicomBundle\Entity\Participant;

/**
 * CompetitionSeasonStageRepository.
 */
class CompetitionSeasonStageRepository extends AbstractEntityRepository
{
    /**
     * @param CompetitionSeason $competitionSeason
     */
    public function getCurrent(CompetitionSeason $competitionSeason)
    {
    }

    /**
     * Gets the current CompetitionSeasonStage for a given competition.
     *
     * @param Competition $competition Competition Entity.
     *
     * @throws \Doctrine\ORM\NonUniqueResultException
     *
     * @return mixed
     */
    public function findCurrentFromCompetition(Competition $competition)
    {
        // Get current Competition Season for Competition
        $qb = $this->entityManager->createQueryBuilder();
        $qb->select('cs');
//        $qb = $this->createQueryBuilder('cs');

        $competitionSeason = $qb
            ->from('ViscaLicomBundle:CompetitionSeason', 'cs')
            ->join(
                'ViscaLicomBundle:CompetitionGraph',
                'cg',
                Join::WITH,
                'cs.id = cg.competitionSeason'
            )
            ->where('cg.label = :label')
            ->andWhere('cg.competition = :cid')
            ->setParameters(
                [
                    'cid' => $competition->getId(),
                    'label' => CompetitionGraphLabelCode::CURRENT_CODE,
                ]
            )
            ->getQuery()->getOneOrNullResult();

        return $this->findCurrentByCompetitionSeason($competitionSeason);
    }

    /**
     * Find current CompetitionSeasonStage by competition Season.
     *
     * @param CompetitionSeason $competitionSeason CompetitionSeason entity.
     *
     * @return CompetitionSeasonStage
     */
    public function findCurrentByCompetitionSeason(
        CompetitionSeason $competitionSeason
    ) {
        // First we get the CompetitionStageType of the CompetitionSeason
        $qb = $this->entityManager->createQueryBuilder();
        $competitionStageType = $qb->select('st')
            ->from('ViscaLicomBundle:CompetitionStageType', 'st')
            ->join(
                'ViscaLicomBundle:CompetitionSeasonGraph',
                'sg',
                Join::WITH,
                'st.id = sg.competitionStageType'
            )
            ->where('sg.competitionSeason = :sid')
            ->andWhere('sg.label = :label')
            ->setParameters(
                [
                    'sid' => $competitionSeason->getId(),
                    'label' => CompetitionSeasonGraphLabelCode::CURRENT_CODE,
                ]
            )
            ->getQuery()->getOneOrNullResult();

        if ($competitionStageType instanceof CompetitionStageType) {
            $qb = $this->entityManager->createQueryBuilder();
            $competitionSeasonStage = $qb->select('ss')
                ->from('ViscaLicomBundle:CompetitionSeasonStage', 'ss')
                ->join(
                    'ViscaLicomBundle:CompetitionStage',
                    'cstage',
                    Join::WITH,
                    'ss.competitionStage = cstage.id'
                )
                ->where('ss.competitionSeason = :cs')
                ->andWhere('cstage.competitionStageType1 = :stype')
                ->setParameters(
                    [
                        'stype' => $competitionStageType,
                        'cs' => $competitionSeason,
                    ]
                )
                ->getQuery()->getOneOrNullResult();

            return $competitionSeasonStage;
        }
    }

    /**
     * Returns the current CompetitionSeasonStage for the Participant
     *
     * @param int $participantId Participant Id
     *
     * @return CompetitionSeasonStage[]
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function findCurrentByParticipant(
        $participantId
    ) {
        // First we get the CompetitionStageType of the CompetitionSeason
        $qb = $this->entityManager->createQueryBuilder();
        $competitionStageType = $qb->select('cst')
            ->from('ViscaLicomBundle:Standing', 's')
            ->join(
                'ViscaLicomBundle:CompetitionSeasonStage',
                'cst',
                Join::WITH,
                'cst.id = s.entityId'
            )
            ->join(
                'ViscaLicomBundle:CompetitionStage',
                'cstg',
                Join::WITH,
                'cstg.id = cst.competitionStage'
            )
            ->join(
                'ViscaLicomBundle:CompetitionSeason',
                'cs',
                Join::WITH,
                'cs.id = cst.competitionSeason'
            )
            ->join(
                'ViscaLicomBundle:CompetitionSeasonGraph',
                'csg',
                Join::WITH,
                'csg.competitionStageType = cstg.competitionStageType1 AND csg.label = :label'
            )
            ->join(
                'ViscaLicomBundle:StandingRow',
                'sr',
                Join::WITH,
                'sr.standing = s.id'
            )
            ->where('s.entity = :sentity')
            ->andWhere('s.standingType = :stype')
            ->andWhere('sr.participant = :participant')
            ->setParameters(
                [
                    'sentity' => EntityCode::COMPETITION_SEASON_STAGE_CODE,
                    'stype' => StandingTypeCode::LEAGUE_TABLE_CODE,
                    'label' => CompetitionSeasonGraphLabelCode::CURRENT_CODE,
                    'participant' => $participantId,
                ]
            )
            ->getQuery()->getResult();

        return $competitionStageType;
    }
}
