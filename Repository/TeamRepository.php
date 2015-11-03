<?php

namespace Visca\Bundle\LicomBundle\Repository;

use Visca\Bundle\DoctrineBundle\Repository\Abstracts\AbstractEntityRepository;
use Visca\Bundle\LicomBundle\Entity\Athlete;
use Visca\Bundle\LicomBundle\Entity\Code\EntityCode;
use Visca\Bundle\LicomBundle\Entity\Sport;
use Visca\Bundle\LicomBundle\Entity\Team;
use Visca\Bundle\LicomBundle\Repository\Traits\GetAndSortByIdTrait;
use Visca\Bundle\LicomBundle\Entity\ProfileEntityGraph;

/**
 * Class TeamRepository.
 */
class TeamRepository extends AbstractEntityRepository
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
     * @return Team[]
     */
    public function getAllIds()
    {
        return $this
            ->createQueryBuilder('t')
            ->getQuery()
            ->getArrayResult();
    }

    /**
     * Finds a Team by an Athlete.
     *
     * @param Athlete $athlete Athlete
     *
     * @return Team
     */
    public function findByAthlete(Athlete $athlete)
    {
        return $this
            ->createQueryBuilder('t')
            ->join('t.participantMembership', 'pm')
            ->where('pm.entity = :entityCode')
            ->andWhere('pm.participant = :athleteId')
            ->andWhere('t.id = pm.entityId')
            ->setParameters(
                [
                    'entityCode' => EntityCode::PARTICIPANT_CODE,
                    'athleteId' => $athlete->getId(),
                ]
            )
            ->getQuery()
            ->getOneOrNullResult();
    }

    /**
     * Finds all Teams by an Athlete.
     *
     * @param Athlete $athlete Athlete
     *
     * @return Team
     */
    public function findAllByAthlete(Athlete $athlete)
    {
        return $this
            ->createQueryBuilder('t')
            ->join('t.participantMembership', 'pm')
            ->where('pm.entity = :entityCode')
            ->andWhere('pm.participant = :athleteId')
            ->andWhere('t.id = pm.entityId')
            ->setParameters(
                [
                    'entityCode' => EntityCode::PARTICIPANT_CODE,
                    'athleteId' => $athlete->getId(),
                ]
            )
            ->getQuery()
            ->getResult();
    }

    /**
     * Returns the top teams by Sport.
     *
     * @param Sport $sport Sport
     *
     * @return Team[]
     */
    public function findTop(Sport $sport)
    {
        $profileGraphRepository = $this->repositoryProfileEntityGraph;

        $profileTopEntries = $profileGraphRepository->findByLabel(
            $sport,
            'top-teams'
        );

        $topTeamsIds = [];
        /** @var ProfileEntityGraph $profileEntityGraph */
        foreach ($profileTopEntries as $profileEntityGraph) {
            $topTeamsIds[] = $profileEntityGraph->getEntityId();
        }

        $topTeams = $this->getAndSortById($topTeamsIds);

        return $topTeams;
    }
}
