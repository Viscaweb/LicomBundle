<?php

namespace Visca\Bundle\LicomBundle\Repository;

use Doctrine\ORM\Query\Expr\Join;
use Visca\Bundle\DoctrineBundle\Repository\Abstracts\AbstractEntityRepository;
use Visca\Bundle\LicomBundle\Entity\Athlete;
use Visca\Bundle\LicomBundle\Entity\Code\EntityCode;
use Visca\Bundle\LicomBundle\Entity\LocalizationTranslation;
use Visca\Bundle\LicomBundle\Entity\LocalizationTranslationType;
use Visca\Bundle\LicomBundle\Entity\Profile;
use Visca\Bundle\LicomBundle\Entity\ProfileTranslationGraph;
use Visca\Bundle\LicomBundle\Entity\Sport;
use Visca\Bundle\LicomBundle\Entity\Team;

/**
 * Class TeamRepository.
 */
class TeamRepository extends AbstractEntityRepository
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
     * @return array
     */
    public function findWithNoSlug()
    {
        // Only using sport 1 (football) to get the teams as they're the only ones important at this moment
        // as it is the only sport where the teams have a web address
        return $this
            ->createQueryBuilder('t')
            ->addSelect('COUNT(p.id) AS totalTranslations')
            ->leftJoin(
                LocalizationTranslation::class,
                'lt',
                Join::WITH,
                'lt.entityId = t.id AND lt.localizationTranslationType = :slugType'
            )
            ->leftJoin(
                ProfileTranslationGraph::class,
                'ptg',
                Join::WITH,
                'ptg.localizationTranslation = lt.id'
            )
            ->leftJoin(
                Profile::class,
                'p',
                Join::WITH,
                'p.id = ptg.profile'
            )
            ->setParameter('slugType', LocalizationTranslationType::TEAM_SLUG_ID)
            ->where("t.sport = 1 AND del = 'no'")
            ->groupBy('t.id')
            ->having('totalTranslations < 7')
            ->getQuery()
            ->getResult();
    }

    /**
     * Returns the top teams by Sport.
     *
     * @param Sport    $sport Sport
     * @param int|null $limit Limit of results
     *
     * @return Team[]
     */
    public function findTop(Sport $sport, $limit = null)
    {
        $profileGraphRepository = $this->repositoryProfileEntityGraph;

        $profileTopEntriesIds = $profileGraphRepository->findByLabel(
            $sport,
            'top-teams',
            true,
            $limit
        );

        $queryBuilder = $this->createQueryBuilder('c')
            ->where('c.id IN (:ids)')
            ->orderBy('FIELD(c.id, :ids)')
            ->setParameter('ids', $profileTopEntriesIds);

        $query = $queryBuilder->getQuery();
        $this->setCacheStrategy($query);

        return $query->getResult();
    }
}
