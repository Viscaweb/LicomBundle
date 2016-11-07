<?php

namespace Visca\Bundle\LicomBundle\Repository\Counter;

use Doctrine\ORM\QueryBuilder;
use Visca\Bundle\LicomBundle\Entity\Competition;
use Visca\Bundle\LicomBundle\Entity\MatchStatusDescription;
use Visca\Bundle\LicomBundle\Entity\Sport;
use Visca\Bundle\LicomBundle\Repository\CompetitionSeasonStageRepository;
use Visca\Bundle\LicomBundle\Repository\MatchRepository;

/**
 * Provides a bunch of methods to count the matches with given criteria.
 *
 * Class MatchCounterRepository
 */
class MatchCounterRepository
{
    /**
     * @var MatchRepository Match Repository
     */
    protected $matchRepository;
    /**
     * @var CompetitionSeasonStageRepository Competition Season Stage Repository
     */
    protected $competitionSeasonStageRepository;
    /**
     * @var int
     */
    private $resultCacheLifetime = 60;

    /**
     * MatchCounterRepository constructor.
     *
     * @param MatchRepository                  $matchRepository
     * @param CompetitionSeasonStageRepository $competitionSeasonStageRepository
     */
    public function __construct(
        MatchRepository $matchRepository,
        CompetitionSeasonStageRepository $competitionSeasonStageRepository
    ) {
        $this->matchRepository = $matchRepository;
        $this->competitionSeasonStageRepository = $competitionSeasonStageRepository;
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
        $sportIsValid = $this->competitionSeasonStageRepository
            ->createQueryBuilder('stage')
            ->select('stage.id')
            ->join('stage.competitionSeason', 'season')
            ->join('season.competition', 'competition')
            ->join('competition.competitionCategory', 'competitionCategory')
            ->join('competitionCategory.sport', 'sport')
            ->where('sport.id = :sportId');

        $qb
            ->andWhere($qb->expr()->exists($sportIsValid))
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
        $competitionIsValid = $this->competitionSeasonStageRepository
            ->createQueryBuilder('stage')
            ->select('stage.id')
            ->join('stage.competitionSeason', 'season')
            ->join('season.competition', 'competition')
            ->join('competition.competitionCategory', 'competitionCategory')
            ->where('competition.id = :competitionId');

        $qb
            ->andWhere($qb->expr()->exists($competitionIsValid))
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
        $queryBuilder = $this->getMatchQueryBuilder()
            ->join('m.matchStatusDescription', 'MatchStatusDescription')
            ->join('m.competitionSeasonStage', 'stage')
            ->join('stage.competitionSeason', 'season')
            ->join('season.competition', 'competition')
            ->join('competition.competitionCategory', 'competitionCategory')
            ->join('competitionCategory.sport', 'sport')
            ->where('sport.id = :sportId')
            ->andWhere('MatchStatusDescription.category = :statusCategory')
            ->andWhere("DATE_ADD(m.startDate,1, 'day') > CURRENT_TIMESTAMP()")
            ->setParameter('statusCategory', MatchStatusDescription::IN_PROGRESS_KEY)
            ->setParameter('sportId', $sport->getId());

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

        $this->filterByMatchStatusCategory(
            $queryBuilder,
            MatchStatusDescription::IN_PROGRESS_KEY
        );
        $this->filterByCompetition($queryBuilder, $competition);

        return $this->getScalarResult($queryBuilder);
    }
}
