<?php

namespace Visca\Bundle\LicomBundle\Repository;

use Doctrine\ORM\Query\Expr\Join;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\NoResultException;
use Visca\Bundle\DoctrineBundle\Repository\Abstracts\AbstractEntityRepository;
use Visca\Bundle\LicomBundle\Entity\Code\CompetitionGraphLabelCode;
use Visca\Bundle\LicomBundle\Entity\Competition;
use Visca\Bundle\LicomBundle\Entity\CompetitionSeason;

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
    public function findCurrentFromCompetition(Competition $competition)
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
