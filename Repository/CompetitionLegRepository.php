<?php


namespace Visca\Bundle\LicomBundle\Repository;

use Doctrine\ORM\Query\Expr\Join;
use Visca\Bundle\DoctrineBundle\Repository\Abstracts\AbstractEntityRepository;
use Visca\Bundle\LicomBundle\Entity\CompetitionLeg;

/**
 * Class CompetitionLegRepository
 */
class CompetitionLegRepository extends AbstractEntityRepository
{
    /**
     * @var ProfileEntityGraphRepository
     */
    protected $repositoryProfileEntityGraph;

    /**
     * @param ProfileEntityGraphRepository $repositoryProfileEntityGraph Repository
     */
    public function setRepositoryProfileEntityGraph(
        ProfileEntityGraphRepository $repositoryProfileEntityGraph
    ) {
        $this->repositoryProfileEntityGraph = $repositoryProfileEntityGraph;
    }

    /**
     * @param int[] $competitionRoundIds List of competitionRound ids
     *
     * @return \Visca\Bundle\LicomBundle\Entity\CompetitionLeg[]
     */
    public function findByCompetitionRound(
        $competitionRoundIds
    ) {
        $queryBuilder = $this->entityManager->createQueryBuilder();

        $queryBuilder->select('Leg')
            ->from('ViscaLicomBundle:CompetitionLeg', 'Leg')
            ->where('Leg.competitionRound IN (:id)')
            ->setParameters(
                [
                    'id' => $competitionRoundIds
                ]
            );

        return $queryBuilder->getQuery()->getResult();
    }


    /**
     * @param int[] $competitionRoundIds List of competitionRound ids
     *
     * @return \Visca\Bundle\LicomBundle\Entity\CompetitionLeg[]
     */
    public function findByCompetitionRoundAndHasMatches(
        $competitionRoundIds
    ) {
        $queryBuilder = $this->entityManager->createQueryBuilder();

        $queryBuilder->select('Leg')
            ->from('ViscaLicomBundle:CompetitionLeg', 'Leg')
            ->join(
                'ViscaLicomBundle:Match',
                'Match',
                Join::INNER_JOIN,
                'Match.competitionLeg = Leg.id'
            )
            ->where('Leg.competitionRound IN (:id)')
            ->setParameters(
                [
                    'id' => $competitionRoundIds
                ]
            );

        return $queryBuilder->getQuery()->getResult();
    }


    /**
     * @param int[] $competitionRoundIds List of competitionRound ids
     *
     * @param int $seasonStageGraphLabelCode
     *
     * @return \Visca\Bundle\LicomBundle\Entity\CompetitionLeg
     */
    public function findByCompetitionRoundAndLabel(
        $competitionRoundIds,
        $seasonStageGraphLabelCode
    ) {
        $queryBuilder = $this->entityManager->createQueryBuilder();

        $queryBuilder->select('Leg')
            ->from('ViscaLicomBundle:CompetitionLeg', 'Leg')
            ->join(
                'ViscaLicomBundle:CompetitionRoundGraph',
                'RoundGraph',
                Join::INNER_JOIN,
                'RoundGraph.competitionLeg = Leg.id'
            )
            ->where('RoundGraph.competitionRound IN (:id)')
            ->andWhere('RoundGraph.label = :label')
            ->setParameters(
                [
                    'id' => $competitionRoundIds,
                    'label' => $seasonStageGraphLabelCode,
                ]
            );

        return $queryBuilder->getQuery()->getOneOrNullResult();
    }

    /**
     * @param int[] $competitionRoundIds List of competitionRound ids
     *
     * @param int $seasonStageGraphLabelCode
     *
     * @return \Visca\Bundle\LicomBundle\Entity\CompetitionLeg
     */
    public function findByCompetitionRoundAndLabelAndHasMatches(
        $competitionRoundIds,
        $seasonStageGraphLabelCode
    ) {
        $queryBuilder = $this->entityManager->createQueryBuilder();

        $queryBuilder->select('Leg')
            ->from('ViscaLicomBundle:CompetitionLeg', 'Leg')
            ->join(
                'ViscaLicomBundle:CompetitionRoundGraph',
                'RoundGraph',
                Join::INNER_JOIN,
                'RoundGraph.competitionLeg = Leg.id'
            )
            ->join(
                'ViscaLicomBundle:Match',
                'Match',
                Join::INNER_JOIN,
                'Match.competitionLeg = Leg.id'
            )
            ->where('RoundGraph.competitionRound IN (:id)')
            ->andWhere('RoundGraph.label = :label')
            ->setParameters(
                [
                    'id' => $competitionRoundIds,
                    'label' => $seasonStageGraphLabelCode,
                ]
            );

        return $queryBuilder->getQuery()->getResult();
    }

    /**
     * @param int|null $limit Limit
     *
     * @return array
     */
    public function getAllIds($limit = null)
    {
        $queryBuilder = $this->createQueryBuilder('cl')->select('cl.id');

        if (isset($limit)) {
            $queryBuilder->setMaxResults($limit);
        }

        return $queryBuilder->getQuery()->getArrayResult();
    }

    /**
     * Returns the competition leg that has matches from the id's given.
     *
     * @param array $competitionLegsIds
     *
     * @return array
     */
    public function findByIdAndHasMatches($competitionLegsIds = array())
    {
        $queryBuilder = $this->entityManager->createQueryBuilder();

        $queryBuilder->select('Leg')
            ->from('ViscaLicomBundle:CompetitionLeg', 'Leg')
            ->join(
                'ViscaLicomBundle:Match',
                'Match',
                Join::INNER_JOIN,
                'Match.competitionLeg = Leg.id'
            )
            ->where('Leg.id IN (:id)')
            ->setParameters(
                [
                    'id' => $competitionLegsIds
                ]
            );

        return $queryBuilder->getQuery()->getResult();

    }
}
