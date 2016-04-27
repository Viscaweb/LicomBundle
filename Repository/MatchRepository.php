<?php

namespace Visca\Bundle\LicomBundle\Repository;

use DateTime;
use DateTimeInterface;
use Doctrine\ORM\Query\Expr;
use Doctrine\ORM\Query\Expr\Join;
use Visca\Bundle\DoctrineBundle\Repository\Abstracts\AbstractEntityRepository;
use Visca\Bundle\LicomBundle\Entity\Athlete;
use Visca\Bundle\LicomBundle\Entity\Code\MatchResultTypeCode;
use Visca\Bundle\LicomBundle\Entity\Competition;
use Visca\Bundle\LicomBundle\Entity\CompetitionSeasonStage;
use Visca\Bundle\LicomBundle\Entity\Enum\MatchStatusDescriptionCategoryType;
use Visca\Bundle\LicomBundle\Entity\Match;
use Visca\Bundle\LicomBundle\Entity\MatchParticipant;
use Visca\Bundle\LicomBundle\Entity\Participant;
use Visca\Bundle\LicomBundle\Entity\Sport;
use Visca\Bundle\LicomBundle\Repository\Traits\UTCAltererTrait;

/**
 * Class MatchRepository.
 */
class MatchRepository extends AbstractEntityRepository
{
    use UTCAltererTrait;

    /**
     * @param string $alias
     * @param null   $indexBy
     * @param null   $matchParticipantConditionType
     * @param null   $matchParticipantCondition
     *
     * @return \Doctrine\ORM\QueryBuilder
     */
    public function createQueryBuilder(
        $alias,
        $indexBy = null,
        $matchParticipantConditionType = null,
        $matchParticipantCondition = null
    ) {
        $queryBuilder = parent::createQueryBuilder($alias, $indexBy);
        $queryBuilder
            ->select($alias, 'aux', 'mp', 'p')
            ->leftJoin(
                "$alias.matchParticipant",
                'mp',
                $matchParticipantConditionType,
                $matchParticipantCondition
            )
            ->join(
                "mp.participant",
                'p'
            )
            ->leftJoin("$alias.aux", 'aux')
            ->setCacheable(false);

        return $queryBuilder;
    }

    /**
     * Finds a match by its country id.
     *
     * @param int    $countryId       Country ID
     * @param array  $whereConditions Extra conditions
     * @param array  $whereArguments  Extra condition's parameters
     * @param null   $limit           Limit
     * @param null   $offset          Limit offset
     * @param null   $orderField      Order field
     * @param string $orderType       Order type
     *
     * @return Match[]
     */
    public function findByCountryId(
        $countryId,
        array $whereConditions = [],
        array $whereArguments = [],
        $limit = null,
        $offset = null,
        $orderField = null,
        $orderType = 'ASC'
    ) {
        $query = $this
            ->createQueryBuilder('m')
            ->join('m.competitionSeasonStage', 'stage')
            ->join('stage.competitionSeason', 'season')
            ->join('season.competition', 'competition')
            ->join('competition.competitionCategory', 'competitionCategory')
            ->where('competitionCategory.country = :countryId')
            ->setParameter('countryId', $countryId)
            ->orderBy('m.startDate', 'ASC');

        foreach ($whereConditions as $condition) {
            $query->andWhere($condition);
        }

        foreach ($whereArguments as $key => $value) {
            $query->setParameter($key, $value);
        }

        if (is_numeric($limit)) {
            $query->setMaxResults($limit);
        }

        if (is_numeric($offset)) {
            $query->setFirstResult($offset);
        }

        if (!is_null($orderField)) {
            $query->orderBy('m.'.$orderField, $orderType);
        }

        return $query->getQuery()->getResult();
    }

    /**
     * Finds a match by its competition id.
     *
     * @param int    $competitionId   Competition ID
     * @param array  $whereConditions Extra conditions
     * @param array  $whereArguments  Extra condition's parameters
     * @param null   $limit           Limit
     * @param null   $offset          Limit offset
     * @param null   $orderField      Order field
     * @param string $orderType       Order type
     *
     * @return Match[]
     */
    public function findByCompetitionId(
        $competitionId,
        array $whereConditions = [],
        array $whereArguments = [],
        $limit = null,
        $offset = null,
        $orderField = null,
        $orderType = 'ASC'
    ) {
        $query = $this
            ->createQueryBuilder('m')
            ->join('m.competitionSeasonStage', 'stage')
            ->join('stage.competitionSeason', 'season')
            ->join('season.competition', 'competition')
            ->where('competition.id = :competitionId')
            ->setParameter('competitionId', $competitionId)
            ->orderBy('m.startDate', 'ASC');

        foreach ($whereConditions as $condition) {
            $query->andWhere($condition);
        }

        foreach ($whereArguments as $key => $value) {
            $query->setParameter($key, $value);
        }

        if (is_numeric($limit)) {
            $query->setMaxResults($limit);
        }

        if (is_numeric($offset)) {
            $query->setFirstResult($offset);
        }

        if (!is_null($orderField)) {
            $query->orderBy('m.'.$orderField, $orderType);
        }

        return $query->getQuery()->getResult();
    }

    /**
     * Finds a match by its competition id and startAt order by now.
     *
     * @param int $competitionId Competition id.
     * @param int $limit         Limit
     * @param int $offset        Offset
     *
     * @return Match[]
     */
    public function findByCompetitionIdAndStart(
        $competitionId,
        $limit = null,
        $offset = null
    ) {
        $qb = $this
            ->createQueryBuilder('m')
            ->join('m.competitionSeasonStage', 'stage')
            ->join('stage.competitionSeason', 'season')
            ->join('season.competition', 'competition')
            ->where('competition.id = :competitionId')
            ->setParameter('competitionId', $competitionId);

        if (is_numeric($limit)) {
            $qb->setMaxResults($limit);
        }

        $dateNow = new DateTime('now');
        $this->alterDateObjects($dateNow);
        if (is_numeric($offset) && $offset >= 0) {
            $qb->andWhere('m.startDate >= :now')
                ->setParameter('now', $dateNow)
                ->setFirstResult($offset);
        }

        if (is_numeric($offset) && $offset < 0) {
            $qb->andWhere('m.startDate < :now')
                ->setParameter('now', $dateNow)
                ->setFirstResult(abs($offset));
        }

        return $qb->getQuery()->getResult();
    }

    /**
     * Finds all matches.
     *
     * @return Match[]
     */
    public function findAll()
    {
        return $this
            ->createQueryBuilder('m')
            ->addSelect('r')
            ->leftJoin('mp.matchResult', 'r')
            ->getQuery()
            ->getResult();
    }

    /**
     * Gets a match being played in a date range.
     *
     * @param DateTime $periodFrom Matches from this date
     * @param DateTime $periodTo   Matches until this date
     *
     * @return integer[] Array of match id
     */
    public function findMatchIdByPeriod(
        DateTime $periodFrom,
        DateTime $periodTo
    ) {
        $this->alterDateObjects($periodFrom, $periodTo);
        $queryBuilder = parent::createQueryBuilder('m');
        $rows = $queryBuilder
            ->select('m.id')
            ->where('m.startDate >= :from')
            ->andWhere('m.startDate < :to')
            ->setParameters(
                [
                    'from' => $periodFrom,
                    'to' => $periodTo,
                ]
            )
            ->getQuery()
            ->setCacheable(false)
            ->getArrayResult();

        return array_column($rows, 'id');
    }

    /**
     * Returns the matches where the given participants are playing.
     *
     * @param int|array $participantId           Participant ID
     * @param array     $whereConditions         Extra conditions
     * @param array     $whereArguments          Extra condition's parameters
     * @param null      $limit                   Limit the number of registers.
     *                                           As currently this method is, it does not limit the
     *                                           number of matches retrieved
     * @param null      $offset                  Limit offset
     * @param null      $orderField              Order field
     * @param string    $orderType               Order type
     * @param bool      $preloadBothParticipants Preload both participants in the resultset
     * @param null      $participantPosition     Specify if the Participant is HOME|AWAY
     *
     * @return \Visca\Bundle\LicomBundle\Entity\Match[]
     */
    public function findMatchByParticipant(
        $participantId,
        array $whereConditions = [],
        array $whereArguments = [],
        $limit = null,
        $offset = null,
        $orderField = null,
        $orderType = 'ASC',
        $preloadBothParticipants = false,
        $participantPosition = null
    ) {
        $query = $this->createQueryBuilder('m');
        $query->select('m', 'mp');

        if (is_array($participantId)) {
            $query
                ->where('mp.participant in (:participant)')
                ->setParameter('participant', implode(',', $participantId));
        } else {
            $query
                ->where('mp.participant = :participant')
                ->setParameter('participant', $participantId);
        }

        foreach ($whereConditions as $condition) {
            $query->andWhere($condition);
        }

        foreach ($whereArguments as $key => $value) {
            $query->setParameter($key, $value);
        }

        if (is_numeric($limit)) {
            $query->setMaxResults($limit);
        }

        if (is_numeric($offset)) {
            $query->setFirstResult($offset);
        }

        if (!is_null($orderField)) {
            $query->orderBy('m.'.$orderField, $orderType);
        }

        if ($preloadBothParticipants) {
            $query->leftJoin('m.matchParticipant', 'mp2')
                ->andWhere(
                    '(mp.number=:home and mp2.number=:away) OR (mp.number=:away and mp2.number=:home)'
                )
                ->setParameter('home', MatchParticipant::HOME)
                ->setParameter('away', MatchParticipant::AWAY);
            $query->addSelect('mp2');
        }

        if (!is_null($participantPosition)) {
            $query
                ->andWhere('mp.number = :position')
                ->setParameter(
                    'position',
                    $participantPosition
                );
        }

        $query->groupBy('m.id');

        return $query->getQuery()->getResult();
    }

    /**
     * @param int    $participantId
     * @param array  $whereConditions
     * @param array  $whereArguments
     * @param null   $limit
     * @param null   $offset
     * @param null   $orderField
     * @param string $orderType
     * @param int    $matchResultType
     * @param null   $participantPosition
     *
     * @return array
     */
    public function findMatchByParticipantPreloadResults(
        $participantId,
        array $whereConditions = [],
        array $whereArguments = [],
        $limit = null,
        $offset = null,
        $orderField = null,
        $orderType = 'ASC',
        $matchResultType = MatchResultTypeCode::RUNNING_SCORE_CODE,
        $participantPosition = null
    ) {
        $query = $this->createQueryBuilder('m');
        $query
            ->select('m', 'mp', 'mp2', 'mr', 'mr2')
            ->leftJoin('m.matchParticipant', 'mp2')
            ->leftJoin(
                'mp.matchResult',
                'mr',
                Join::WITH,
                'mr.matchResultType = :resultType'
            )
            ->leftJoin(
                'mp2.matchResult',
                'mr2',
                Join::WITH,
                'mr2.matchResultType = :resultType'
            )
            ->where(
                '(mp.number=:home and mp2.number=:away) OR (mp.number=:away and mp2.number=:home)'
            );

        if (is_array($participantId)) {
            $query
                ->andWhere('mp.participant in (:participant)')
                ->setParameter('participant', implode(',', $participantId));
        } else {
            $query
                ->andWhere('mp.participant = :participant')
                ->setParameter('participant', $participantId);
        }

        foreach ($whereConditions as $condition) {
            $query->andWhere($condition);
        }

        foreach ($whereArguments as $key => $value) {
            $query->setParameter($key, $value);
        }

        if (is_numeric($limit)) {
            $query->setMaxResults($limit);
        }

        if (is_numeric($offset)) {
            $query->setFirstResult($offset);
        }

        if (!is_null($orderField)) {
            $query->orderBy('m.'.$orderField, $orderType);
        }

        if (!is_null($participantPosition)) {
            $query
                ->andWhere('mp.number = :position')
                ->setParameter(
                    'position',
                    $participantPosition
                );
        }

        $query
            ->setParameter('home', MatchParticipant::HOME)
            ->setParameter('away', MatchParticipant::AWAY)
            ->setParameter('resultType', $matchResultType)
            ->groupBy('m.id');

        return $query->getQuery()->getResult();
    }

    /**
     * Returns the matches where the given participants are playing.
     *
     * @param Participant[] $homeParticipants List of home participants
     * @param Participant[] $awayParticipants List of away participants
     * @param array         $whereConditions  Extra conditions
     * @param array         $whereArguments   Extra condition's parameters
     * @param null          $limit            Limit
     * @param null          $offset           Limit offset
     * @param null          $orderField       Order field
     * @param string        $orderType        Order type
     *
     * @return Match[]
     */
    public function findMatchByParticipants(
        array $homeParticipants,
        array $awayParticipants,
        array $whereConditions = [],
        array $whereArguments = [],
        $limit = null,
        $offset = null,
        $orderField = null,
        $orderType = 'ASC'
    ) {
        $query = $this
            ->createQueryBuilder('m', null, Expr\Join::WITH, 'mp.number = 1')
            ->addSelect('mp2')
            ->leftJoin(
                'm.matchParticipant',
                'mp2',
                Expr\Join::WITH,
                'mp2.number = 2'
            )
            ->where('mp.participant IN (:homeParticipants)')
            ->andWhere('mp2.participant IN (:awayParticipants)')
            ->having('mp.number = :matchParticipantHomeNumber')
            ->andHaving('mp2.number = :matchParticipantAwayNumber')
            ->setParameter('homeParticipants', $homeParticipants)
            ->setParameter('awayParticipants', $awayParticipants)
            ->setParameter('matchParticipantHomeNumber', MatchParticipant::HOME)
            ->setParameter('matchParticipantAwayNumber', MatchParticipant::AWAY)
            ->groupBy('m.id');

        foreach ($whereConditions as $condition) {
            $query->andWhere($condition);
        }

        foreach ($whereArguments as $key => $value) {
            $query->setParameter($key, $value);
        }

        if (is_numeric($limit)) {
            $query->setMaxResults($limit);
        }

        if (is_numeric($offset)) {
            $query->setFirstResult($offset);
        }

        if (!is_null($orderField)) {
            $query->orderBy('m.'.$orderField, $orderType);
        }

        return $query->getQuery()->getResult();
    }

    /**
     * Find all matches having a coverage about the comments, for the given
     * ProfileID, and range of time.
     *
     * @param datetime $startOn   Match after this date
     * @param datetime $endOn     Match before this date
     * @param int      $profileId Profile ID
     *
     * @return Match[]
     */
    public function findCommented($startOn, $endOn, $profileId)
    {
        $this->alterDateObjects($startOn, $endOn);

        return $this
            ->createQueryBuilder('m')
            ->select(
                'm, mp1, mp2, matchStatusDescription'
            )
            ->join('m.matchParticipant', 'mp1')
            ->join('m.matchParticipant', 'mp2')
            ->leftJoin('m.matchStatusDescription', 'matchStatusDescription')
            ->join(
                'ViscaLicomBundle:MatchAuxProfile',
                'matchAuxProfile',
                'WITH',
                'matchAuxProfile.match = m.id'
            )
            ->join(
                'matchAuxProfile.profile',
                'profile',
                'WITH',
                'profile.id = :profileId'
            )
            ->join('matchAuxProfile.matchAuxProfileType', 'matchAuxProfileType')
            ->where('m.startDate >= :from')
            ->andWhere('m.startDate < :to')
            ->andWhere('matchAuxProfile.value = :value')
            ->andWhere('matchAuxProfileType.code = :coverage')
            ->setParameters(
                [
                    'from' => $startOn,
                    'to' => $endOn,
                    'coverage' => Match::COVERAGE_COMMENT,
                    'value' => '1',
                    'profileId' => $profileId,
                ]
            )
            ->getQuery()
            ->getResult();
    }

    /**
     * Finds Matches that has a given importance and are going to be played in $days days.
     * If the toDays is not set, the query will return all the results biggers than the fromDate
     * And will add the limit if provided.
     *
     * @param string $importance top|important|2nd.
     * @param int    $fromDays   Starting date the match can take place.
     *                           Specified in number of relative days from today.
     * @param int    $toDays     Limit date the match can take place. Specified in number of relative days from today.
     * @param int    $limit      Limit the number of matches returned. Default 3.
     *
     * @return Match[]
     */
    public function findByImportanceInDays(
        $importance,
        $fromDays,
        $toDays = null,
        $limit = null
    ) {
        /*
         * DQL does not implement DATE() mysql function.
         * Here's how to implement it:
         * http://stackoverflow.com/questions/13272224/use-a-date-function-in-a-where-clause-with-dql
         * But it also does not implement INTERVAL neither,
         * So I can't do
         * SELECT * FROM Match WHERE DATE(m.startDate) = (CURDATE() - INTERVAL :days DAY)
         * easily...
         *
         * So I end up constructing a PHP object that holds the date of
         * X days ago, and get those matches that start after (>=) that date.
         * Also, order the result set by startDate, olders first.
         */
        $dateFrom = new \DateTime('+'.$fromDays.' days');

        /*
         * $fromDays = 0 means that we accept matches playing today.
         * Therefore, we could get some matches that are finished.
         *
         * To avoid this behaviour, we must say that we accept only
         * the matches are that playing in future.
         */
        if ($fromDays !== 0) {
            $dateFrom->setTime(0, 0, 0);
        }
        $this->alterDateObjects($dateFrom);

        $queryBuilder = parent::createQueryBuilder('m');
        $queryBuilder
            ->select('m')
            ->setCacheable(false);

        $queryBuilder
            ->join('m.matchAuxProfile', 'ma', Join::WITH)
            ->andWhere('m.startDate >= :start')
            ->andWhere('ma.value = :importance')
            ->orderBy('m.startDate', 'ASC')
            ->setParameter('start', $dateFrom->format('Y-m-d H:i:s'))
            ->setParameter('importance', $importance)
            ->groupBy('m.id');

        /*
         * If we don't have any "to date", don't add it to the query
         */
        if ($toDays !== null) {
            $dateEnd = new \DateTime('+'.$toDays.' days, 23:59:59');
            $this->alterDateObjects($dateEnd);

            $queryBuilder
                ->andWhere('m.startDate <= :end')
                ->setParameter('end', $dateEnd->format('Y-m-d H:i:s'));
        }

        if ($limit !== null) {
            $queryBuilder->setMaxResults($limit);
        }

        return $queryBuilder
            ->getQuery()
            ->execute();
    }

    /**
     * Finds Matches that has a given importance and are going to be played in $days days.
     * If the toDays is not set, the query will return all the results biggers than the fromDate
     * And will add the limit if provided.
     *
     * @param int    $country     Country entity.
     * @param string $importance  top|important|2nd.
     * @param int    $fromDays    Starting date the match can take place.
     *                            Specified in number of relative days from today.
     * @param int    $toDays      Limit date the match can take place. Specified in number of relative days from today.
     * @param int    $limit       Limit the number of matches returned. Default 3.
     *
     * @return \Visca\Bundle\LicomBundle\Entity\Match[]
     */
    public function findByCountryImportanceInDays(
        $countryId,
        $importance,
        $fromDays,
        $toDays = null,
        $limit = null
    ) {
        /*
         * DQL does not implement DATE() mysql function.
         * Here's how to implement it:
         * http://stackoverflow.com/questions/13272224/use-a-date-function-in-a-where-clause-with-dql
         * But it also does not implement INTERVAL neither,
         * So I can't do
         * SELECT * FROM Match WHERE DATE(m.startDate) = (CURDATE() - INTERVAL :days DAY)
         * easily...
         *
         * So I end up constructing a PHP object that holds the date of
         * X days ago, and get those matches that start after (>=) that date.
         * Also, order the result set by startDate, olders first.
         */
        $dateFrom = new \DateTime('+'.$fromDays.' days');

        /*
         * $fromDays = 0 means that we accept matches playing today.
         * Therefore, we could get some matches that are finished.
         *
         * To avoid this behaviour, we must say that we accept only
         * the matches are that playing in future.
         */
        if ($fromDays !== 0) {
            $dateFrom->setTime(0, 0, 0);
        }
        $this->alterDateObjects($dateFrom);

        $queryBuilder = parent::createQueryBuilder('m');
        $queryBuilder
            ->select('m')
            ->setCacheable(false);

        $queryBuilder
            ->join('m.matchAuxProfile', 'ma', Join::WITH)
            ->join(
                'm.competitionSeasonStage',
                'css',
                Join::WITH
            )
            ->join(
                'css.competitionSeason',
                'cs',
                Join::WITH
            )
            ->join(
                'cs.competition',
                'c',
                Join::WITH
            )
            ->join(
                'c.competitionCategory',
                'cc',
                Join::WITH,
                'cc.country = :country'
            )
            ->andWhere('m.startDate >= :start')
            ->andWhere('ma.value = :importance')
            ->orderBy('m.startDate', 'ASC')
            ->setParameter('start', $dateFrom->format('Y-m-d H:i:s'))
            ->setParameter('importance', $importance)
            ->setParameter('country', $countryId)
            ->groupBy('m.id');

        /*
         * If we don't have any "to date", don't add it to the query
         */
        if ($toDays !== null) {
            $dateEnd = new \DateTime('+'.$toDays.' days, 23:59:59');
            $this->alterDateObjects($dateEnd);

            $queryBuilder
                ->andWhere('m.startDate <= :end')
                ->setParameter('end', $dateEnd->format('Y-m-d H:i:s'));
        }

        if ($limit !== null) {
            $queryBuilder->setMaxResults($limit);
        }

        return $queryBuilder
            ->getQuery()
            ->execute();
    }

    /**
     * Gets list of matches that happen in a given day and optionally has a given
     * state.
     *
     * @param DateTime    $dateFrom
     * @param DateTime    $dateTo
     * @param string|null $status Any of the valid MatchStatusDescriptionCategoryType
     * @param null        $sportId
     * @param bool        $eagerFetching
     *
     * @return \Visca\Bundle\LicomBundle\Entity\Match[]
     */
    public function findByDateAndStatusAndSport(
        DateTime $dateFrom,
        DateTime $dateTo,
        $status = null,
        $sportId = null,
        $eagerFetching = false
    ) {
        $queryBuilder = parent::createQueryBuilder('m')
            ->select('m');

        if ($eagerFetching) {
            $queryBuilder
                ->join(
                    'ViscaLicomBundle:MatchParticipant',
                    'mp1',
                    'WITH',
                    'mp1.match = m AND mp1.number = :homeNumber'
                )
                ->join(
                    'ViscaLicomBundle:MatchParticipant',
                    'mp2',
                    'WITH',
                    'mp2.match = m AND mp2.number = :awayNumber'
                )
                ->where('mp1.id IS NOT NULL')
                ->andWhere('mp2.id IS NOT NULL')
                ->setParameter('homeNumber', MatchParticipant::HOME)
                ->setParameter('awayNumber', MatchParticipant::AWAY);
        }

        /*
         * Filter by date
         */
        $this->alterDateObjects($dateFrom, $dateTo);

        $queryBuilder
            ->andWhere('m.startDate BETWEEN :dateFrom AND :dateTo')
            ->setParameter('dateFrom', $dateFrom->format('Y-m-d H:i'))
            ->setParameter('dateTo', $dateTo->format('Y-m-d H:i'));

        /*
         * Filter the status
         */
        if ($status !== null) {
            $statusCategories = $this->prepareStatusCategories($status);

            $queryBuilder
                ->leftJoin(
                    'Visca\Bundle\LicomBundle\Entity\MatchStatusDescription',
                    's',
                    Join::WITH,
                    's.id = m.matchStatusDescription'
                )
                ->andWhere('s.category IN (:categories)')
                ->setParameter('categories', $statusCategories);
        }


        /*
         * if we have the sport id
         */
        if (!is_null($sportId) && is_numeric($sportId)) {
            $queryBuilder
                // Where sport
                ->join(
                    "mp1.participant",
                    'p'
                )
                ->andWhere('p.sport = :sportId')
                ->setParameter('sportId', $sportId);
        }

        /*
         * Return the results
         */

        return $queryBuilder->getQuery()->getResult();
    }

    /**
     * @param \DateTime $dateFrom                  Initial date.
     * @param \DateTime $dateTo                    End date.
     * @param int[]     $competitionSeasonStageIds List of CompetitionSeasonStages.
     * @param null      $status                    Match status.
     *
     * @return array
     */
    public function findByDateAndStatusAndCompetitionSeasonStage(
        DateTime $dateFrom,
        DateTime $dateTo,
        $competitionSeasonStageIds,
        $status = null
    ) {
//        $timeFormat = 'H:i';
//        if ($hour !== null) {
//            $timeFormat = $hour;
//        }

        /*
         * Filter by date
         */
        $this->alterDateObjects($dateFrom, $dateTo);
        $queryBuilder = $this
            ->createQueryBuilder('m')
            ->join(
                'ViscaLicomBundle:MatchParticipant',
                'mp1',
                'WITH',
                'mp1.match = m AND mp1.number = :homeNumber'
            )
            ->join(
                'ViscaLicomBundle:MatchParticipant',
                'mp2',
                'WITH',
                'mp2.match = m AND mp2.number = :awayNumber'
            )
            ->where('m.startDate BETWEEN :dateFrom AND :dateTo')
            ->andWhere(
                'm.competitionSeasonStage IN (:competitionSeasonStageIds)'
            )
            ->andWhere('mp1.id IS NOT NULL')
            ->andWhere('mp2.id IS NOT NULL')
            ->setParameter('homeNumber', MatchParticipant::HOME)
            ->setParameter('awayNumber', MatchParticipant::AWAY)
            ->setParameter('dateFrom', $dateFrom->format('Y-m-d H:i:s'))
            ->setParameter('dateTo', $dateTo->format('Y-m-d H:i:s'))
            ->setParameter(
                'competitionSeasonStageIds',
                $competitionSeasonStageIds
            );

        /*
         * Filter the status
         */
        if ($status !== null) {
            $statusCategories = $this->prepareStatusCategories($status);

            $queryBuilder
                ->leftJoin(
                    'Visca\Bundle\LicomBundle\Entity\MatchStatusDescription',
                    's',
                    Join::WITH,
                    's.id = m.matchStatusDescription'
                )
                ->andWhere('s.category IN (:categories)')
                ->setParameter('categories', $statusCategories);
        }

        /*
         * Return the results
         */

        return $queryBuilder->getQuery()->getResult();
    }

    /**
     * @param string            $status Match Status description.
     * @param DateTimeInterface $date   A date.
     * @param int|null          $limit  How many matches we want.
     *
     * @return Match[]
     */
    public function findMatchesByStatusBeforeDate(
        $status,
        DateTimeInterface $date,
        $limit = null
    ) {
        return $this->findMatchesByStatusAndDateInterval(
            $date,
            $status,
            true,
            $limit,
            null,
            null
        );
    }

    /**
     * @param string            $status Match Status description.
     * @param DateTimeInterface $date   A date.
     * @param int|null          $limit  How many matches we want.
     *
     * @return Match[]
     */
    public function findMatchesByStatusAfterDate(
        $status,
        DateTimeInterface $date,
        $limit = null
    ) {
        return $this->findMatchesByStatusAndDateInterval(
            $date,
            $status,
            false,
            $limit,
            null,
            null
        );
    }

    /**
     * @param string|null       $status Match Status description.
     * @param DateTimeInterface $date   A date.
     * @param bool|true         $before Do we want matches before the date?
     * @param null              $limit  How many matches we want.
     * @param int|null          $sportId
     * @param array             $competitionSeasonStageIds
     *
     * @return Match[]
     */
    public function findMatchesByStatusAndDateInterval(
        DateTimeInterface $date,
        $status,
        $before = true,
        $limit = null,
        $sportId = null,
        $competitionSeasonStageIds = array()
    ) {

        $symbol = $before ? '<' : '>=';
        $order = $before ? 'DESC' : 'ASC';
        if ($before) {
            $date->setTime(23, 59, 59);
        } else {
            $date->setTime(0, 0, 0);
        }

        $this->alterDateObjects($date);

        $queryBuilder = $this->createQueryBuilder('m');
        $queryBuilder
            ->andWhere('m.startDate '.$symbol.' :start')
            ->orderBy('m.startDate', $order)
            ->setMaxResults($limit)
            ->setParameter('start', $date->format('Y-m-d H:i:s'));

        if (!is_null($status)) {
            $statusCategories = $this->prepareStatusCategories($status);

            $queryBuilder
                ->leftJoin(
                    'Visca\Bundle\LicomBundle\Entity\MatchStatusDescription',
                    's',
                    Join::WITH,
                    's.id = m.matchStatusDescription'
                )
                ->andWhere('s.category IN (:categories)')
                ->setParameter('categories', $statusCategories);
        }

        /*
        * if we have the sport id
        */
        if (!is_null($sportId) && is_numeric($sportId)) {
            $queryBuilder
                // join the participant to filter by sport
                ->join(
                    'ViscaLicomBundle:MatchParticipant',
                    'mp1',
                    'WITH',
                    'mp1.match = m AND mp1.number = :homeNumber'
                )
                ->andWhere('mp1.id IS NOT NULL')
                ->setParameter('homeNumber', MatchParticipant::HOME)
                // Where sport
                ->join(
                    "mp1.participant",
                    'p1'
                )
                ->andWhere('p1.sport = :sportId')
                ->setParameter('sportId', $sportId);
        }

        if (!is_null($competitionSeasonStageIds)) {
            $queryBuilder
                // Where CompetitionSeasonStages
                ->andWhere(
                    'm.competitionSeasonStage IN (:competitionSeasonStageIds)'
                )
                ->setParameter(
                    'competitionSeasonStageIds',
                    $competitionSeasonStageIds
                );
        }

        if ($limit !== null) {
            $queryBuilder->setMaxResults($limit);
        }

        $results = $queryBuilder
            ->getQuery()
            ->execute();

        return $results;
    }

    /**
     * @param string            $status Match Status description.
     * @param DateTimeInterface $date   A date.
     * @param int[]             $competitionSeasonStageIds
     * @param int|null          $limit  How many matches we want.
     *
     * @return \Visca\Bundle\LicomBundle\Entity\Match[]
     */
    public function findMatchesByStatusBeforeDateAndCompetitionSeasonStage(
        $status,
        DateTimeInterface $date,
        $competitionSeasonStageIds,
        $limit = null
    ) {
        return $this->findMatchesByStatusAndDateIntervalAndCompetitionSeasonStage(
            $status,
            $date,
            $competitionSeasonStageIds,
            true,
            $limit
        );
    }

    /**
     * @param                   $status
     * @param DateTimeInterface $date
     * @param                   $competitionSeasonStageIds
     * @param null              $limit
     *
     * @return \Visca\Bundle\LicomBundle\Entity\Match[]
     */
    public function findMatchesByStatusAfterDateAndCompetitionSeasonStage(
        $status,
        DateTimeInterface $date,
        $competitionSeasonStageIds,
        $limit = null
    ) {
        return $this->findMatchesByStatusAndDateIntervalAndCompetitionSeasonStage(
            $status,
            $date,
            $competitionSeasonStageIds,
            false,
            $limit
        );
    }

    /**
     * @param DateTimeInterface $date    A date.
     * @param string            $status  Match Status description.
     * @param int|null          $sportId The sport Id.
     * @param int|null          $limit   How many matches we want.
     *
     * @return Match[]
     */
    public function findByDateAndStatusAndSportBeforeDate(
        DateTimeInterface $date,
        $status,
        $sportId,
        $limit = null
    ) {
        return $this->findMatchesByStatusAndDateInterval(
            $date,
            $status,
            true,
            $limit,
            $sportId,
            null
        );
    }

    /**
     * @param DateTimeInterface $date    A date.
     * @param string            $status  Match Status description.
     * @param int|null          $sportId The sport Id.
     * @param int|null          $limit   How many matches we want.
     *
     * @return Match[]
     */
    public function findByDateAndStatusAndSportAfterDate(
        DateTimeInterface $date,
        $status,
        $sportId,
        $limit = null
    ) {
        return $this->findMatchesByStatusAndDateInterval(
            $date,
            $status,
            false,
            $limit,
            $sportId,
            null
        );
    }


    /**
     * @param DateTimeInterface $date                     A date.
     * @param string            $status                   Match Status description.
     * @param array|null        $competitionSeasonStageId The sport Id.
     * @param int|null          $limit                    How many matches we want.
     *
     * @return Match[]
     */
    public function findByDateAndStatusAndCompetitionSeasonStageBeforeDate(
        DateTimeInterface $date,
        $status,
        $competitionSeasonStageId,
        $limit = null
    ) {
        return $this->findMatchesByStatusAndDateInterval(
            $date,
            $status,
            true,
            $limit,
            null,
            $competitionSeasonStageId
        );
    }

    /**
     * @param DateTimeInterface $date                     A date.
     * @param string            $status                   Match Status description.
     * @param array|null        $competitionSeasonStageId The Competition Season Stage Id.
     * @param int|null          $limit                    How many matches we want.
     *
     * @return Match[]
     */
    public function findMatchesByStatusAndCompetitionSeasonStageAfterDate(
        DateTimeInterface $date,
        $status,
        $competitionSeasonStageId,
        $limit = null
    ) {
        return $this->findMatchesByStatusAndDateInterval(
            $date,
            $status,
            false,
            $limit,
            null,
            $competitionSeasonStageId
        );
    }

    /**
     * @param string            $status
     * @param DateTimeInterface $date
     * @param int[]             $competitionSeasonStageIds
     * @param bool|true         $before
     * @param null              $limit
     *
     * @return Match[]
     */
    public function findMatchesByStatusAndDateIntervalAndCompetitionSeasonStage(
        $status,
        DateTimeInterface $date,
        $competitionSeasonStageIds,
        $before = true,
        $limit = null
    ) {
        $dateOperator = $before ? '<' : '>=';
        $order = $before ? 'DESC' : 'ASC';
        if ($before) {
            $date->setTime(23, 59, 59);
        } else {
            $date->setTime(0, 0, 0);
        }

        $this->alterDateObjects($date);

        $queryBuilder = $this->createQueryBuilder('m');
        $queryBuilder
            ->andWhere('m.startDate '.$dateOperator.' :start')
            ->andWhere(
                'm.competitionSeasonStage IN (:competitionSeasonStageIds)'
            )
            ->orderBy('m.startDate', $order)
            ->setMaxResults($limit)
            ->setParameter('start', $date->format('Y-m-d H:i:s'))
            ->setParameter(
                'competitionSeasonStageIds',
                $competitionSeasonStageIds
            );

        if ($status !== null) {
            $statusCategories = $this->prepareStatusCategories($status);

            $queryBuilder
                ->leftJoin(
                    'Visca\Bundle\LicomBundle\Entity\MatchStatusDescription',
                    's',
                    Join::WITH,
                    's.id = m.matchStatusDescription'
                )
                ->andWhere('s.category IN (:categories)')
                ->setParameter('categories', $statusCategories);
        }

        if ($limit !== null) {
            $queryBuilder->setMaxResults($limit);
        }

        return $queryBuilder
            ->getQuery()
            ->execute();
    }


    /**
     * @param int        $competitionSeasonId     CompetitionSeason entity ID
     * @param int        $competitionStageType1Id CompetitionStageType1 entity ID
     * @param int|null   $competitionStageType2Id CompetitionStageType2 entity ID
     * @param int[]|null $competitionRoundId      CompetitionRound entity ID
     * @param int[]|null $competitionLegId        CompetitionLeg entity ID
     *
     * @return mixed
     */
    public function findBySeasonStageTypeRoundAndLeg(
        $competitionSeasonId,
        $competitionStageType1Id,
        $competitionStageType2Id = null,
        $competitionRoundId = null,
        $competitionLegId = null
    ) {
        $queryBuilder = $this->createQueryBuilder('m');

        $queryBuilder
            ->from('ViscaLicomBundle:CompetitionSeasonStage', 'css')
            ->from('ViscaLicomBundle:CompetitionStage', 'cs')
            ->where('cs.competitionStageType1 = :cstype1')
            ->andWhere('css.competitionSeason = :competitionSeason');

        if ($competitionStageType2Id !== null) {
            $queryBuilder->andWhere('cs.competitionStageType2 = :cstype2')
                ->setParameter('cstype2', $competitionStageType2Id);
        }

        $queryBuilder
            ->andWhere('css.competitionStage = cs.id')
            ->andWhere('m.competitionSeasonStage = css.id');

        if ($competitionRoundId !== null && count($competitionRoundId) > 0) {
            //            if (is_array($competitionRoundId)) {
            $queryBuilder->andWhere('m.competitionRound IN (:rids)')
                ->setParameter('rids', $competitionRoundId);
//            } elseif (is_numeric($competitionRoundId)) {
//                $queryBuilder->andWhere('m.competitionRound = :rid')
//                    ->setParameter('rid', $competitionRoundId);
//            }
        }

        if ($competitionLegId !== null && count($competitionLegId) > 0) {
            $queryBuilder->andWhere('m.competitionLeg IN (:lid)')
                ->setParameter('lid', $competitionLegId);
        }

        $queryBuilder
            ->setParameter('competitionSeason', $competitionSeasonId)
            ->setParameter('cstype1', $competitionStageType1Id);

        return $queryBuilder->getQuery()->execute();
    }

    /**
     * Find matches by an Athlete and a IncidentType
     *
     * @param Athlete  $athlete               Athlete entity
     * @param int      $matchIncidentTypeCode MatchIncidentTypeCode value
     *
     * @param null|int $year                  Year to filter
     *
     * @return mixed
     */
    public function findByAthleteAndMatchIncidentTypeAndYear(
        Athlete $athlete,
        $matchIncidentTypeCode,
        $year = null
    ) {
        $queryBuilder = $this->entityManager->createQueryBuilder();

        $queryBuilder
            ->select('m', 'mp2')
            ->from('Visca\Bundle\LicomBundle\Entity\Match', 'm')
            ->leftJoin("m.matchParticipant", 'mp')
            ->leftJoin('m.matchParticipant', 'mp2')
            ->join(
                'Visca\Bundle\LicomBundle\Entity\MatchIncident',
                'mi',
                Join::WITH,
                'mi.matchParticipant = mp.id'
            )
            ->where('mi.participant = :athlete')
            ->andWhere('mi.matchIncidentType = :type')
            ->setParameters(
                [
                    'athlete' => $athlete->getId(),
                    'type' => $matchIncidentTypeCode,
                ]
            )
            ->orderBy('m.startDate', 'DESC');

        if ($year !== null) {
            $queryBuilder->andWhere('m.startDate > :year')
                ->andWhere('m.startDate < :yearEnd')
                ->setParameter('year', $year.'-01-01 00:00:00')
                ->setParameter('yearEnd', $year.'-12-31 23:59:59');
        }

        return $queryBuilder->getQuery()->execute();
    }

    /**
     * Returns the number of LIVE matches for the given sport for all the countries grouped by Contry.
     *
     * @param Sport          $sport                  Sport Entity
     * @param null|int[]     $competitionsListed     Ids to avoid
     * @param \DateTime|null $dateFrom               DateTime
     * @param \DateTime|null $dateTo                 DateTime
     * @param string|null    $status                 Status
     * @param array|null     $competitionCategoryIds Status
     *
     * @return array
     */
    public function countMatchesByCompetitionSportAndStatus(
        Sport $sport,
        $competitionsListed = null,
        \DateTime $dateFrom = null,
        \DateTime $dateTo = null,
        $status = null,
        $competitionCategoryIds = null
    ) {
        // Gets the custom query builder
        $queryBuilder = $this->getCompetitionCategoryBuilder($sport);

        /*
         * If we have some listed categories, remove them from the listing
         */
        if (!is_null($competitionsListed)
            && is_array($competitionsListed) && !empty($competitionsListed)
        ) {
            $queryBuilder
                ->andWhere(
                    'season.competition NOT IN (:competitionsListed)'
                )
                ->setParameter(
                    'competitionsListed',
                    $competitionsListed
                );
        }

        // Add the status filter
        if (!is_null($status)) {
            // Prepare the $status key filter
            $statusCategories = $this->prepareStatusCategories($status);

            $queryBuilder
                ->andWhere('matchStatusDescription.category IN (:categories)')
                ->setParameter('categories', $statusCategories);
        }

        // if we have the $competitionCategoryIds filter by id's
        if (!is_null($competitionCategoryIds)) {
            $queryBuilder
                ->andWhere('season.competition IN (:ccIds)')
                ->setParameter('ccIds', $competitionCategoryIds);
        }

        // Add the filter by date if needed.
        if (!is_null($dateFrom)) {
            $this->alterDateObjects($dateFrom);
            $queryBuilder
                ->andWhere('m.startDate >= :from')
                ->setParameter('from', $dateFrom->format('Y-m-d H:i:s'));
        }
        if (!is_null($dateTo)) {
            $this->alterDateObjects($dateTo);
            $queryBuilder
                ->andWhere('m.startDate < :to')
                ->setParameter('to', $dateTo->format('Y-m-d H:i:s'));
        }

        // gets the results in an Array
        $results = $queryBuilder
            ->getQuery()
            ->getResult(\Doctrine\ORM\AbstractQuery::HYDRATE_ARRAY);

        // Refactor the array returned by the query builder
        // It will return an array $key => $value
        //   $key = Id of the CompetitionCategory
        //   $value = Number of matches
        $totalByCompetitionCategory = [];
        if (!empty($results)) {
            foreach ($results as $result) {
                $totalByCompetitionCategory[$result['id']] = $result['total'];
            }
        }

        return $totalByCompetitionCategory;
    }

    /**
     * Returns the prepared query builder
     *
     * @param Sport $sport
     *
     * @return \Doctrine\ORM\QueryBuilder
     */
    private function getCompetitionCategoryBuilder(Sport $sport)
    {
        /*
         * Join to get the Country and MatchStatusDescription
         * To get the countries and the status of the matches.
         *
         * Also is adding the filter by sport.
         */

        return $this
            ->entityManager
            ->createQueryBuilder()
            ->select('competitionCategory.id', 'count(m.id) as total')
            ->from($this->entityName, 'm')
            ->join(
                'ViscaLicomBundle:MatchParticipant',
                'mp1',
                'WITH',
                'mp1.match = m AND mp1.number = :homeNumber'
            )
            ->join(
                'ViscaLicomBundle:MatchParticipant',
                'mp2',
                'WITH',
                'mp2.match = m AND mp2.number = :awayNumber'
            )
            // Join with all the classes to get all the data.
            ->join('m.competitionSeasonStage', 'stage')
            ->join('stage.competitionSeason', 'season')
            ->join('season.competition', 'competition')
            ->join('competition.competitionCategory', 'competitionCategory')
            ->join('m.matchStatusDescription', 'matchStatusDescription')
            // To be sure we have the two participants
            ->where('mp1.id IS NOT NULL')
            ->andWhere('mp2.id IS NOT NULL')
            ->setParameter('homeNumber', MatchParticipant::HOME)
            ->setParameter('awayNumber', MatchParticipant::AWAY)
            // Where sport
            ->andWhere('competitionCategory.sport = :sportId')
            ->setParameter('sportId', $sport->getId())
            // Group by Country
            ->addGroupBy('competitionCategory.id');
    }


    /**
     * Gets the list of Matches for a Participant and status given
     *
     * @param string $status        Status to find
     * @param int    $participantId Participant to find
     *
     * @return array
     */
    public function findByStatusAndParticipant(
        $status,
        $participantId
    ) {
        $queryBuilder = $this->entityManager->createQueryBuilder();
        $queryBuilder
            ->select('m')
            ->from('Visca\Bundle\LicomBundle\Entity\Match', 'm');
        /*
         * Filter the status
         */
        $statusCategories = $this->prepareStatusCategories($status);

        $queryBuilder
            ->leftJoin(
                'ViscaLicomBundle:MatchStatusDescription',
                's',
                Join::WITH,
                's.id = m.matchStatusDescription'
            )
            ->join(
                'ViscaLicomBundle:MatchParticipant',
                'mp',
                Join::WITH,
                'mp.match = m'
            )
            ->andWhere('s.category IN (:categories)')
            ->andWhere('mp.id = :participant')
            ->setParameter('categories', $statusCategories)
            ->setParameter('participant', $participantId);

        /*
         * Return the results
         */

        return $queryBuilder->getQuery()->getResult();
    }

    /**
     * Returns the matches ids where the competition is the given one
     *
     * @param array    $matchesIds
     * @param int|null $competitionId
     *
     * @return array
     */
    public function filterMatchesIdsByCompetition(
        $matchesIds = array(),
        $competitionId = null
    ) {
        $queryBuilder = $this->entityManager->createQueryBuilder();

        /**
         * If no copmpetition, return all the matches id's
         */
        if (is_null($competitionId)) {
            return $matchesIds;
        }

        /**
         * Filter by match ids and competition
         */
        if (is_array($matchesIds) && !empty($matchesIds)) {
            $queryBuilder
                ->select('m.id')
                ->from('Visca\Bundle\LicomBundle\Entity\Match', 'm')
                ->join('m.competitionSeasonStage', 'stage')
                ->join('stage.competitionSeason', 'season')
                ->join('season.competition', 'competition')
                ->join('competition.competitionCategory', 'competitionCategory')
                ->andWhere('m.id IN (:matchesIds)')
                ->andWhere('season.competition = :competitionId')
                ->setParameter('matchesIds', $matchesIds)
                ->setParameter('competitionId', $competitionId);

            /*
             * Return the results
             */

            $results = $queryBuilder->getQuery()->getResult();

            return $results;
        }


        return array();
    }


    /**
     * Returns the array of status to search based on the status given
     *
     * @param string $status Status of matches to search
     *
     * @return array
     */
    private function prepareStatusCategories($status)
    {
        switch ($status) {
            case MatchStatusDescriptionCategoryType::INPROGRESS:
                $statusCategories = [
                    MatchStatusDescriptionCategoryType::INPROGRESS,
                ];
                break;

            case MatchStatusDescriptionCategoryType::NOTSTARTED:
                $statusCategories = [
                    MatchStatusDescriptionCategoryType::NOTSTARTED,
                    MatchStatusDescriptionCategoryType::CANCELLED,
                    MatchStatusDescriptionCategoryType::UNKNOWN,
                ];
                break;

            case MatchStatusDescriptionCategoryType::FINISHED:
            default:
                $statusCategories = [
                    MatchStatusDescriptionCategoryType::UNKNOWN,
                    MatchStatusDescriptionCategoryType::FINISHED,
                    MatchStatusDescriptionCategoryType::INPROGRESS,
                    MatchStatusDescriptionCategoryType::CANCELLED,
                    MatchStatusDescriptionCategoryType::NOTSTARTED,
                ];
                break;
        }

        return $statusCategories;
    }

    /**
     * @param string[] $participantNames
     * @return Match[]
     */
    public function findAllByParticipantNames(array $participantNames)
    {
        $query = parent::createQueryBuilder('m')
            ->select('m', 'aux')
            ->leftJoin('m.aux', 'aux');

        foreach ($participantNames as $key => $name) {
            $number = $key + 1;
            $query->join(
                    MatchParticipant::class,
                    "mp{$number}",
                    Join::WITH,
                    "mp{$number}.number = {$number} and mp{$number}.match = m.id"
                )
                ->join(Participant::class, "p{$number}", Join::WITH, "p{$number}.id = mp{$number}.participant")
                ->andWhere("p{$number}.name = :p{$number}Name")
                ->setParameter("p{$number}Name", $name);
        }

        return $query->getQuery()->getResult();
    }

    /**
     * @param array $ids Ids
     *
     * @return Match[]
     */
    public function getAndSortByIds($ids)
    {
        $queryBuilder = $this->createQueryBuilder('m')
            ->where('m.id IN (:ids)')
            ->orderBy('FIELD(m.id, :ids)')
            ->setParameter('ids', $ids);

        return $queryBuilder->getQuery()->getResult();
    }

    /**
     * @param Competition $competition
     * @param Participant $home
     * @param Participant $away
     * @return Match[]
     */
    public function findByCompetitionAndHomeAndAwayParticipants(
        Competition $competition,
        Participant $home,
        Participant $away
    ) {
        $query = parent::createQueryBuilder('m')
            ->join(
                'm.matchParticipant',
                'homeParticipant',
                Join::WITH,
                'homeParticipant.participant = :homeParticipant and homeParticipant.number = :home'
            )
            ->join(
                'm.matchParticipant',
                'awayParticipant',
                Join::WITH,
                'awayParticipant.participant = :awayParticipant and awayParticipant.number = :away'
            )
            ->join('m.competitionSeasonStage', 'stage')
            ->join('stage.competitionSeason', 'season')
            ->join('season.competition', 'competition')
            ->where('competition = :competition')
            ->setParameters(
                [
                    'homeParticipant' => $home,
                    'awayParticipant' => $away,
                    'home' => MatchParticipant::HOME,
                    'away' => MatchParticipant::AWAY,
                    'competition' => $competition,
                ]
            );

        return $query->getQuery()->getResult();
    }


    /**
     * @param Datetime $start
     * @param DateTime $end
     * @return array
     */
    public function findMatchesWhichMostRelevantWasNotUpdatedBetweenDates(
        \Datetime $start,
        \DateTime $end
    ) {
        $query = parent::createQueryBuilder('m')
            ->select(
                [
                    'm',
                    'homeMatchParticipant',
                    'awayMatchParticipant',
                    'homeParticipant',
                    'awayParticipant',
                    'stage',
                    'season',
                    'competition',
                ]
            )
            ->join(
                'm.matchParticipant',
                'homeMatchParticipant',
                Join::WITH,
                'homeMatchParticipant.number = :home'
            )
            ->join(
                'homeMatchParticipant.participant',
                'homeParticipant'
            )
            ->join(
                'm.matchParticipant',
                'awayMatchParticipant',
                Join::WITH,
                'awayMatchParticipant.number = :away'
            )
            ->join(
                'awayMatchParticipant.participant',
                'awayParticipant'
            )
            ->join('m.competitionSeasonStage', 'stage')
            ->join('stage.competitionSeason', 'season')
            ->join('season.competition', 'competition')
            ->where('m.updatedAt between :start and :end')
            ->setParameters(
                [
                    'home' => MatchParticipant::HOME,
                    'away' => MatchParticipant::AWAY,
                    'start' => $start,
                    'end' => $end,
                ]
            );

        return $query->getQuery()->getResult();
    }
}
