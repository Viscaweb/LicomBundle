<?php


namespace Visca\Bundle\LicomBundle\Repository;

use Doctrine\ORM\Query\Expr\Join;
use Visca\Bundle\DoctrineBundle\Repository\Abstracts\AbstractEntityRepository;
use Visca\Bundle\LicomBundle\Entity\CompetitionLeg;
use Visca\Bundle\LicomBundle\Repository\Traits\GetAndSortByIdTrait;

/**
 * Class CompetitionLegRepository
 */
class CompetitionLegRepository extends AbstractEntityRepository
{
    use GetAndSortByIdTrait;

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
     * @param int $seasonStageGraphLabelCode
     *
     * @return \Visca\Bundle\LicomBundle\Entity\CompetitionLeg[]
     */
    public function findByCompetitionRound(
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
}
