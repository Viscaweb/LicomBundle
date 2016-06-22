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
    protected function getMatchQueryBuilder()
    {
        $queryBuilder = $this
            ->matchRepository
            ->createQueryBuilder('m')
            ->select('count(DISTINCT m)');

        $queryBuilder->setCacheable(false);

        return $queryBuilder;
    }

    /**
     * @param QueryBuilder $qb
     * @param Sport        $sport
     */
    private function filterBySport(QueryBuilder $qb, Sport $sport)
    {
        $qb
            ->join('m.competitionSeasonStage', 'stage')
            ->join('stage.competitionSeason', 'season')
            ->join('season.competition', 'competition')
            ->join('competition.competitionCategory', 'competitionCategory')
            ->join('competitionCategory.sport', 'sport')
            ->andWhere('sport.id = :sportId')
            ->setParameter('sportId', $sport->getId());
    }

    /**
     * @param QueryBuilder $qb
     * @param Competition  $competition
     */
    private function filterByCompetition(
        QueryBuilder $qb,
        Competition $competition
    ) {
        $qb
            ->join('m.competitionSeasonStage', 'stage')
            ->join('stage.competitionSeason', 'season')
            ->join('season.competition', 'competition')
            ->join('competition.competitionCategory', 'competitionCategory')
            ->join('competitionCategory.sport', 'sport')
            ->andWhere('competition.id = :competitionId')
            ->setParameter('competitionId', $competition->getId());
    }

    /**
     * @param QueryBuilder $qb
     * @param string       $matchStatusCategory
     */
    private function filterByMatchStatusCategory(
        QueryBuilder $qb,
        $matchStatusCategory
    ) {
        $qb
            ->join('m.matchStatusDescription', 'MatchStatusDescription')
            ->andWhere('MatchStatusDescription.category = :statusCategory')
            ->setParameter('statusCategory', $matchStatusCategory);
    }

    /**
     * @param QueryBuilder $queryBuilder
     *
     * @return int
     */
    private function getScalarResult(QueryBuilder $queryBuilder)
    {
        $query = $queryBuilder->getQuery();
        $query->useResultCache(true, $this->resultCacheLifetime);

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
        $queryBuilder = $this->getMatchQueryBuilder();
        $this->filterBySport($queryBuilder, $sport);

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
        $queryBuilder = $this->getMatchQueryBuilder();
        $this->filterBySport($queryBuilder, $sport);
        $this->filterByMatchStatusCategory(
            $queryBuilder,
            MatchStatusDescription::IN_PROGRESS_KEY
        );

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
        $queryBuilder = $this->getMatchQueryBuilder();

        $this->filterByCompetition($queryBuilder, $competition);
        $this->filterByMatchStatusCategory(
            $queryBuilder,
            MatchStatusDescription::IN_PROGRESS_KEY
        );

        return $this->getScalarResult($queryBuilder);
    }
}
