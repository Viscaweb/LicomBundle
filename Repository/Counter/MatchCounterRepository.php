<?php

namespace Visca\Bundle\LicomBundle\Repository\Counter;

use Doctrine\ORM\QueryBuilder;
use Visca\Bundle\LicomBundle\Entity\Competition;
use Visca\Bundle\LicomBundle\Entity\MatchStatusDescription;
use Visca\Bundle\LicomBundle\Entity\Sport;
use Visca\Bundle\LicomBundle\Repository\MatchRepository;

/**
 * Provides a bunch of methods to count the matches with given criteria.
 *
 * Class MatchCounterRepository
 */
class MatchCounterRepository
{
    /**
     * @var int
     */
    private $resultCacheLifetime = 60;

    /**
     * @var MatchRepository Match Repository
     */
    protected $matchRepository;

    /**
     * @param MatchRepository $matchRepository Match Repository
     */
    public function __construct($matchRepository)
    {
        $this->matchRepository = $matchRepository;
    }

    /**
     * @return QueryBuilder
     */
    protected function getFullMatchQueryBuilder()
    {
        $queryBuilder = $this
            ->matchRepository
            ->createQueryBuilder('m')
            ->setCacheable(false)
            ->select('count(m)')
            ->join('m.competitionSeasonStage', 'stage')
            ->join('stage.competitionSeason', 'season')
            ->join('season.competition', 'competition')
            ->join('competition.competitionCategory', 'competitionCategory')
            ->join('competitionCategory.sport', 'sport');

        return $queryBuilder;
    }

    /**
     * @param QueryBuilder $queryBuilder
     *
     * @return int
     */
    private function getScalarResult(QueryBuilder $queryBuilder)
    {
        $query = $queryBuilder->getQuery();
//        $query->useResultCache(true, $this->resultCacheLifetime);

        return intval($query->getSingleScalarResult());
    }

    /**
     * Returns the number of matches for the given sport.
     *
     * @param Sport $sport Sport Entity
     *
     * @return int
     */
    public function countMatchesBySport(Sport $sport)
    {
        $queryBuilder = $this->getFullMatchQueryBuilder();

        $queryBuilder
            ->where('sport.id = :sportId')
            ->setParameter('sportId', $sport->getId());

        $this->getScalarResult($queryBuilder);
    }

    /**
     * Returns the number of LIVE matches for the given sport.
     *
     * @param Sport $sport Sport Entity
     *
     * @return int
     */
    public function countLiveMatchesBySport(Sport $sport)
    {
        $queryBuilder = $this->getFullMatchQueryBuilder();

        $queryBuilder
            ->join('m.matchStatusDescription', 'MatchStatusDescription')
            ->where('sport.id = :sportId')
            ->andWhere('MatchStatusDescription.category = :statusCategory')
            ->setParameter('sportId', $sport->getId())
            ->setParameter('statusCategory', MatchStatusDescription::IN_PROGRESS_KEY);

        return $this->getScalarResult($queryBuilder);
    }

    /**
     * Returns the number of LIVE matches for the given competition.
     *
     * @param Competition $competition Competition Entity
     *
     * @return int
     */
    public function countLiveMatchesByCompetition(Competition $competition)
    {
        $queryBuilder = $this->getFullMatchQueryBuilder();

        $queryBuilder
            ->join('m.matchStatusDescription', 'MatchStatusDescription')
            ->where('competition.id = :competitionId')
            ->andWhere('MatchStatusDescription.category = :statusCategory')
            ->setParameter('competitionId', $competition->getId())
            ->setParameter('statusCategory', MatchStatusDescription::IN_PROGRESS_KEY);

        return $this->getScalarResult($queryBuilder);
    }
}
