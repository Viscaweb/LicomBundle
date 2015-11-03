<?php

namespace Visca\Bundle\LicomBundle\Repository;

use Visca\Bundle\DoctrineBundle\Repository\Abstracts\AbstractEntityRepository;
use Visca\Bundle\LicomBundle\Entity\Participant;
use Visca\Bundle\LicomBundle\Entity\ProfileEntityGraph;
use Visca\Bundle\LicomBundle\Entity\Sport;
use Visca\Bundle\LicomBundle\Repository\Traits\GetAndSortByIdTrait;

/**
 * Class ParticipantRepository.
 */
class ParticipantRepository extends AbstractEntityRepository
{
    const COMPETITION_SEASON_CODE = 'CompetitionSeason';

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
     * @param int $competitionSeasonId competitionSeasonId
     *
     * @return Participant[]
     */
    public function findByCompetitionSeason($competitionSeasonId)
    {
        return $this
            ->createQueryBuilder('participant')
            ->join(
                'ViscaLicomBundle:ParticipantMembership',
                'participantMembership',
                'WITH',
                'participantMembership.participant = participant.id'
            )
            ->join(
                'participantMembership.entity',
                'entity',
                'WITH',
                'entity.code = :code'
            )
            ->andWhere('participantMembership.entityId = :competitionSeasonId')
            ->setParameter('code', self::COMPETITION_SEASON_CODE)
            ->setParameter('competitionSeasonId', $competitionSeasonId)
            ->getQuery()
            ->getResult();
    }

    /**
     * @param Sport    $sport Sport
     * @param int|null $limit Limit of results
     *
     * @return Participant[]
     */
    public function findTop(Sport $sport, $limit = null)
    {
        $profileGraphRepository = $this->repositoryProfileEntityGraph;

        $profileTopEntries = $profileGraphRepository->findByLabel(
            $sport,
            'top-teams',
            $limit
        );

        $topParticipantsIds = [];
        /** @var ProfileEntityGraph $profileEntityGraph */
        foreach ($profileTopEntries as $profileEntityGraph) {
            $topParticipantsIds[] = $profileEntityGraph->getEntityId();
        }

        $topParticipants = $this->getAndSortById($topParticipantsIds);

        return $topParticipants;
    }

    /**
     * @param int|null $limit Limit
     *
     * @return array
     */
    public function getAllIds($limit = null)
    {
        $queryBuilder = $this->createQueryBuilder('p')->select('p.id');

        if (isset($limit)) {
            $queryBuilder->setMaxResults($limit);
        }

        return $queryBuilder->getQuery()->getArrayResult();
    }
}
