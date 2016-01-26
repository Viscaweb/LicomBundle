<?php

namespace Visca\Bundle\LicomBundle\Repository;

use Doctrine\ORM\Query\Expr\Join;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\NoResultException;
use Visca\Bundle\DoctrineBundle\Repository\Abstracts\AbstractEntityRepository;
use Visca\Bundle\LicomBundle\Entity\Code\CompetitionGraphLabelCode;
use Visca\Bundle\LicomBundle\Entity\Competition;
use Visca\Bundle\LicomBundle\Entity\CompetitionSeason;
use Visca\Bundle\LicomBundle\Entity\Team;

/**
 * Class CompetitionSeasonRepository.
 */
class CompetitionSeasonRepository extends AbstractEntityRepository
{
    /**
     * @param int $competitionId Competition id
     * @param int $label         CompetitionGraphLabel id
     *
     * @return CompetitionSeason
     */
    public function findByCompetitionAndLabel($competitionId, $label)
    {
        $queryBuilder = $this->createQueryBuilder('season');
        $queryBuilder
            ->join('season.competitionGraph', 'graph')
            ->where('graph.competition = :competitionId')
            ->andWhere('graph.label = :label')
            ->setParameters(
                [
                    'competitionId' => $competitionId,
                    'label' => $label,
                ]
            );

        try {
            return $queryBuilder->getQuery()->getSingleResult();
        } catch (NoResultException $exception) {
            return null;
        }
    }

    /**
     * Obtain current CompetitionSeason of a competition.
     *
     * @param Competition $competition Competition entity.
     *
     * @return CompetitionSeason
     */
    public function findCurrentByCompetition(Competition $competition)
    {
        // Get current Competition Season for Competition
        return $this
            ->createQueryBuilder('cs')
            ->join('ViscaLicomBundle:CompetitionGraph', 'cg', Join::WITH, 'cs.id = cg.competitionSeason')
            ->where('cg.label = :label')
            ->andWhere('cg.competition = :cid')
            ->setParameters([
                'cid' => $competition->getId(),
                'label' => CompetitionGraphLabelCode::CURRENT_CODE,
            ])
            ->getQuery()->getOneOrNullResult();
    }

    /**
     * @param Team $team Team entity
     *
     * @return CompetitionSeason[]
     */
    public function findCurrentByTeam(Team $team)
    {
//        SELECT cs.name, cg.*, m.*
//        FROM `Match` as `m`
//        INNER JOIN MatchParticipant as mp ON (m.id = mp.`Match_id`)
//        INNER JOIN CompetitionSeasonStage as css ON(css.id = m.competitionSeasonStage)
//        INNER JOIN CompetitionSeason as cs ON(cs.id = css.CompetitionSeason)
//        INNER JOIN Competition_graph as cg ON (cg.Competition=cs.Competition)
//        WHERE mp.participant = 50 AND cg.label = 1
//        ORDER BY startDate DESC
//        LIMIT 10
        return $this
                ->entityManager
                ->createQueryBuilder()
                ->select('cs')
          //  ->select('cs')
            ->from('ViscaLicomBundle:Match', 'm')
            ->join('ViscaLicomBundle:MatchParticipant', 'mp', Join::WITH, 'm.id = mp.match')
            ->join('ViscaLicomBundle:CompetitionSeasonStage', 'css', Join::WITH, 'css.id = m.competitionSeasonStage')
            ->join('ViscaLicomBundle:CompetitionSeason', 'cs', Join::WITH, 'cs.id = css.competitionSeason')
            ->join('ViscaLicomBundle:CompetitionGraph', 'cg', Join::WITH, 'cg.competition = cs.competition')
            ->where('mp.participant = :participant')
            ->andWhere('cg.label = :label')
            ->setParameters([
                'participant' => $team->getId(),
                'label' => CompetitionGraphLabelCode::CURRENT_CODE
            ])
            ->getQuery()
            ->getResult();
    }


    /**
     * @param array $ids Ids
     *
     * @return ArrayCollection
     */
    public function getByArrayIds(array $ids)
    {
        $queryBuilder = $this
            ->createQueryBuilder('season')
            ->where('season.id IN (:ids)')
            ->setParameter('ids', $ids);

        return $queryBuilder->getQuery()->getResult();
    }
}
