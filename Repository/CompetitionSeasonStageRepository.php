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
use Visca\Bundle\LicomBundle\Entity\Country;
use Visca\Bundle\LicomBundle\Entity\Participant;
use Visca\Bundle\LicomBundle\Entity\Sport;

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

        $competitionSeasonStage = null;
        if ($competitionSeason instanceof CompetitionSeason) {
            $competitionSeasonStage = $this->findCurrentByCompetitionSeason(
                $competitionSeason
            );
        }

        return $competitionSeasonStage;
    }

    /**
     * Finds CompetitionSeasonStage by Country and Sport.
     *
     * @param Country $country Country entity
     * @param Sport   $sport   Sport entity
     *
     * @return null|CompetitionSeasonStage
     */
    public function findByCountryAndSport(Country $country, Sport $sport)
    {
        $qb = $this->entityManager->createQueryBuilder();
        $qb->select('css');
        $query = $qb
            ->from('ViscaLicomBundle:CompetitionSeasonStage', 'css')
            ->join(
                'ViscaLicomBundle:CompetitionStage',
                'cstage',
                Join::WITH,
                'cstage.id = css.competitionStage'
            )
            ->join(
                'ViscaLicomBundle:CompetitionSeason',
                'cs',
                Join::WITH,
                'cs.id = css.competitionSeason'
            )
            ->join(
                'ViscaLicomBundle:Competition',
                'c',
                Join::WITH,
                'c.id = cs.competition'
            )
            ->join(
                'ViscaLicomBundle:CompetitionCategory',
                'cc',
                Join::WITH,
                'cc.id = c.competitionCategory'
            )
            ->where('cc.country = :country')
            ->andWhere('cc.sport = :sport')
            ->setParameters(
                [
                    'country' => $country,
                    'sport' => $sport,
                ]
            )
            ->getQuery();

        return $query->getResult();
    }

    /**
     * Finds current CompetitionSeasonStage by Country and Sport.
     *
     * @param Country $country Country entity
     * @param Sport   $sport   Sport entity
     *
     * @return null|CompetitionSeasonStage
     */
    public function findCurrentByCountryAndSport(Country $country, Sport $sport)
    {
        /**
         * SELECT c.name, cs.name, cstage.name
         * FROM CompetitionSeasonStage AS css
         * JOIN CompetitionStage AS cstage ON cstage.id = css.competitionStage
         * JOIN CompetitionSeason AS cs ON cs.id = css.CompetitionSeason
         * JOIN Competition_Graph AS cg ON (cg.label = 1 AND cg.CompetitionSeason = cs.id)
         * JOIN Competition AS c ON (c.id = cg.competition)
         * JOIN CompetitionCategory AS cc ON cc.id = c.CompetitionCategory
         * JOIN CompetitionSeason_graph AS csg ON (csg.CompetitionSeason = cs.id AND csg.label = 1)
         * WHERE cc.Country = 8 AND cc.Sport = 1
         */
        $qb = $this->entityManager->createQueryBuilder();
        $qb->select('css');
        $query = $qb
            ->from('ViscaLicomBundle:CompetitionSeasonStage', 'css')
            ->join(
                'ViscaLicomBundle:CompetitionStage',
                'cstage',
                Join::WITH,
                'cstage.id = css.competitionStage'
            )
            ->join(
                'ViscaLicomBundle:CompetitionSeason',
                'cs',
                Join::WITH,
                'cs.id = css.competitionSeason'
            )
            ->join(
                'ViscaLicomBundle:CompetitionGraph',
                'cg',
                Join::WITH,
                'cg.label = :cgLabel AND cg.competitionSeason = cs.id'
            )
            ->join(
                'ViscaLicomBundle:Competition',
                'c',
                Join::WITH,
                'c.id = cg.competition'
            )
            ->join(
                'ViscaLicomBundle:CompetitionCategory',
                'cc',
                Join::WITH,
                'cc.id = c.competitionCategory'
            )
            ->join(
                'ViscaLicomBundle:CompetitionSeasonGraph',
                'csg',
                Join::WITH,
                'csg.competitionSeason = cs.id AND csg.label = :csgLabel'
            )
            ->where('cc.country = :country')
            ->andWhere('cc.sport = :sport')
            ->setParameters(
                [
                    'country' => $country,
                    'sport' => $sport,
                    'cgLabel' => CompetitionGraphLabelCode::CURRENT_CODE,
                    'csgLabel' => CompetitionSeasonGraphLabelCode::CURRENT_CODE
                ]
            )
            ->getQuery();

        return $query->getResult();
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
        return $this->findLabeledByCompetitionSeason(
            $competitionSeason,
            CompetitionSeasonGraphLabelCode::CURRENT_CODE
        );
    }

    /**
     * @param CompetitionSeason $competitionSeason
     *
     * @return CompetitionSeasonStage
     */
    public function findLastByCompetitionSeason(
        CompetitionSeason $competitionSeason
    ) {
        return $this->findLabeledByCompetitionSeason(
            $competitionSeason,
            CompetitionSeasonGraphLabelCode::LAST_CODE
        );
    }

    /**
     * @param CompetitionSeason $competitionSeason
     *
     * @return CompetitionSeasonStage
     */
    public function findNextByCompetitionSeason(
        CompetitionSeason $competitionSeason
    ) {
        return $this->findLabeledByCompetitionSeason(
            $competitionSeason,
            CompetitionSeasonGraphLabelCode::NEXT_CODE
        );
    }

    /**
     * @param CompetitionSeason $competitionSeason CompetitionSeason entity
     * @param int               $labelCode         Label code.
     *
     * @return CompetitionSeasonStage|null
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function findLabeledByCompetitionSeason(
        CompetitionSeason $competitionSeason,
        $labelCode
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
                    'label' => $labelCode,
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
                ->getQuery()->getResult();

            return $competitionSeasonStage[0];
        }

        return null;
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
        $qb = $this->entityManager->createQueryBuilder();

        $qb
            ->select('css')
            ->from('ViscaLicomBundle:MatchParticipant', 'mp')
            ->join(
                'ViscaLicomBundle:Match',
                'm',
                Join::WITH,
                'm.id = mp.match'
            )
            ->join(
                'ViscaLicomBundle:CompetitionSeasonStage',
                'css',
                Join::WITH,
                'css.id = m.competitionSeasonStage'
            )
            ->join(
                'ViscaLicomBundle:CompetitionSeasonGraph',
                'csg',
                Join::WITH,
                'csg.competitionSeason = css.competitionSeason'
            )
            ->join(
                'ViscaLicomBundle:CompetitionGraph',
                'cg',
                Join::WITH,
                'cg.competitionSeason = css.competitionSeason'
            )
            ->join(
                'ViscaLicomBundle:Competition',
                'c',
                Join::WITH,
                'c.id = cg.competition'
            )
            ->where(
                'mp.participant = :participant',
                'cg.label = :competitionGraphLabel',
                'csg.label = :competitionSeasonGraphLabel'
            )
            ->setParameters(
                [
                    'participant' => $participantId,
                    'competitionGraphLabel' => CompetitionGraphLabelCode::CURRENT_CODE,
                    'competitionSeasonGraphLabel' => CompetitionSeasonGraphLabelCode::CURRENT_CODE
                ]
            );

        $competitionStageType = $qb->getQuery()->getResult();

        return $competitionStageType;
    }

    /**
     * @return CompetitionSeasonStage[]
     */
    public function findGroupedByCompetitionSeason()
    {
        return $this
            ->createQueryBuilder('css')
            ->groupBy('css.competitionSeason')
            ->getQuery()
            ->getResult();
    }
}
