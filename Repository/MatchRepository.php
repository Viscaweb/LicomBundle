<?php

namespace Visca\Bundle\LicomBundle\Repository;

use DateTime;
use DateTimeInterface;
use Doctrine\ORM\Query\Expr;
use Doctrine\ORM\Query\Expr\Join;
use Visca\Bundle\DoctrineBundle\Repository\Abstracts\AbstractEntityRepository;
use Visca\Bundle\LicomBundle\Entity\Athlete;
use Visca\Bundle\LicomBundle\Entity\CompetitionSeason;
use Visca\Bundle\LicomBundle\Entity\CompetitionSeasonStage;
use Visca\Bundle\LicomBundle\Entity\Enum\MatchStatusDescriptionCategoryType;
use Visca\Bundle\LicomBundle\Entity\Match;
use Visca\Bundle\LicomBundle\Entity\MatchParticipant;
use Visca\Bundle\LicomBundle\Entity\Participant;
use Visca\Bundle\LicomBundle\Entity\Sport;
use Visca\Bundle\LicomBundle\Repository\Traits\GetAndSortByIdTrait;
use Visca\Bundle\LicomBundle\Repository\Traits\UTCAltererTrait;

/**
 * Class MatchRepository.
 */
class MatchRepository extends AbstractEntityRepository
{
    use GetAndSortByIdTrait;
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

        if (is_numeric($offset) && $offset >= 0) {
            $qb->andWhere('m.startDate >= :now')
                ->setParameter('now', new DateTime('now'))
                ->setFirstResult($offset);
        }

        if (is_numeric($offset) && $offset < 0) {
            $qb->andWhere('m.startDate < :now')
                ->setParameter('now', new DateTime('now'))
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
     * @param bool      $preloadBothParticipants ?????
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
        $query->select('m');

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
        }

        if (!is_null($participantPosition)) {
            $query
                ->andWhere('mp.number = :position')
                ->setParameter(
                    'position',
                    $participantPosition
                );
        }

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
                'm, mp1, mp2, match_result1, match_result2, '.
                'match_incident1, match_incident2, matchStatusDescription'
            )
            ->join('m.matchParticipant', 'mp1')
            ->join('m.matchParticipant', 'mp2')
            ->leftJoin('m.matchStatusDescription', 'matchStatusDescription')
            ->leftJoin('mp1.matchResult', 'match_result1')
            ->leftJoin('mp2.matchResult', 'match_result2')
            ->leftJoin('mp1.matchIncident', 'match_incident1')
            ->leftJoin('mp2.matchIncident', 'match_incident2')
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
     * @param int    $fromDays   First day where the match can play.
     * @param int    $toDays     Day limit of the match can play.
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
        $this->alterDateObjects($dateFrom);

        $fromTimeFormat = ($fromDays === 1) ? 'H:i:s' : '00:00:00';

        $queryBuilder = parent::createQueryBuilder('m');
        $queryBuilder
            ->select('m')
            ->setCacheable(false);

        $queryBuilder
            ->join('m.matchAuxProfile', 'ma', Join::WITH)
            ->andWhere('m.startDate >= :start')
            ->andWhere('ma.value = :importance')
            ->orderBy('m.startDate', 'ASC')
            ->setParameter('start', $dateFrom->format('Y-m-d '.$fromTimeFormat))
            ->setParameter('importance', $importance)
            ->groupBy('m.id');

        /*
         * If we don't have any "to date", dont add it to the query
         */
        if ($toDays !== null) {
            $dateEnd = new \DateTime('+'.$toDays.' days');
            $this->alterDateObjects($dateEnd);
            $queryBuilder
                ->andWhere('m.startDate <= :end')
                ->setParameter('end', $dateEnd->format('Y-m-d 23:59:59'));
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
     * @param string|null $status        Any of the valid MatchStatusDescriptionCategoryType
     * @param bool        $eagerFetching
     *
     * @return \Visca\Bundle\LicomBundle\Entity\Match[]
     */
    public function findByDateAndStatus(
        DateTime $dateFrom,
        DateTime $dateTo,
        $status = null,
        $eagerFetching = false
    ) {
        if ($eagerFetching) {
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
                ->where('mp1.id IS NOT NULL')
                ->andWhere('mp2.id IS NOT NULL')
                ->setParameter('homeNumber', MatchParticipant::HOME)
                ->setParameter('awayNumber', MatchParticipant::AWAY);
        } else {
            $queryBuilder = $queryBuilder = parent::createQueryBuilder('m')
                ->select('m');
        }

        /*
         * Filter by date
         */
        $this->alterDateObjects($dateFrom, $dateTo);
        $queryBuilder
            ->where('m.startDate BETWEEN :dateFrom AND :dateTo')
            ->setParameter('dateFrom', $dateFrom->format('Y-m-d H:i'))
            ->setParameter('dateTo', $dateTo->format('Y-m-d H:i'));

        /*
         * Filter the status
         */
        if ($status !== null) {
            switch ($status) {
                case MatchStatusDescriptionCategoryType::INPROGRESS:
                    $statusCategories = [MatchStatusDescriptionCategoryType::INPROGRESS];
                    break;

                case MatchStatusDescriptionCategoryType::NOTSTARTED:
                    $statusCategories = [MatchStatusDescriptionCategoryType::NOTSTARTED];
                    break;

                case MatchStatusDescriptionCategoryType::FINISHED:
                default:
                    $statusCategories = [
                        MatchStatusDescriptionCategoryType::FINISHED,
                        MatchStatusDescriptionCategoryType::CANCELLED,
                        MatchStatusDescriptionCategoryType::UNKNOWN,
                    ];
                    break;
            }

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
     * @param \DateTime              $dateFrom
     * @param \DateTime              $dateTo
     * @param CompetitionSeasonStage $competitionSeasonStage
     * @param null                   $status
     *
     * @return array
     */
    public function findByDateAndStatusAndCompetitionSeasonStage(
        $dateFrom,
        $dateTo,
        CompetitionSeasonStage $competitionSeasonStage,
        $hour = null,
        $status = null
    ) {
        $timeFormat = 'H:i';
        if ($hour !== null) {
            $timeFormat = $hour;
        }

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
            ->andWhere('m.competitionSeasonStage = :competitionSeasonStage')
            ->andWhere('mp1.id IS NOT NULL')
            ->andWhere('mp2.id IS NOT NULL')
            ->setParameter('homeNumber', MatchParticipant::HOME)
            ->setParameter('awayNumber', MatchParticipant::AWAY)
            ->setParameter('dateFrom', $dateFrom->format('Y-m-d '.$timeFormat))
            ->setParameter('dateTo', $dateTo->format('Y-m-d '.$timeFormat))
            ->setParameter('competitionSeasonStage', $competitionSeasonStage);

        /*
         * Filter the status
         */
        if ($status !== null) {
            switch ($status) {
                case MatchStatusDescriptionCategoryType::INPROGRESS:
                    $statusCategories = [MatchStatusDescriptionCategoryType::INPROGRESS];
                    break;

                case MatchStatusDescriptionCategoryType::NOTSTARTED:
                    $statusCategories = [MatchStatusDescriptionCategoryType::NOTSTARTED];
                    break;

                case MatchStatusDescriptionCategoryType::FINISHED:
                default:
                    $statusCategories = [
                        MatchStatusDescriptionCategoryType::FINISHED,
                        MatchStatusDescriptionCategoryType::CANCELLED,
                        MatchStatusDescriptionCategoryType::UNKNOWN,
                    ];
                    break;
            }

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
            $status,
            $date,
            true,
            $limit
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
            $status,
            $date,
            false,
            $limit
        );
    }

    /**
     * @param string            $status Match Status description.
     * @param DateTimeInterface $date   A date.
     * @param bool|true         $before Do we want matches before the date?
     * @param null              $limit  How many matches we want.
     *
     * @return Match[]
     */
    public function findMatchesByStatusAndDateInterval(
        $status,
        DateTimeInterface $date,
        $before = true,
        $limit = null
    ) {
        $this->alterDateObjects($date);

        $symbol = $before ? '<' : '>=';
        $order = $before ? 'DESC' : 'ASC';
        $dateFormat = $before ? 'Y-m-d 23:59:59' : 'Y-m-d 00:00:00';

        $queryBuilder = $this->createQueryBuilder('m');
        $queryBuilder
            ->andWhere('m.startDate '.$symbol.' :start')
            ->orderBy('m.startDate', $order)
            ->setMaxResults($limit)
            ->setParameter('start', $date->format($dateFormat));

        switch ($status) {
            case MatchStatusDescriptionCategoryType::INPROGRESS:
                $statusCategories = [MatchStatusDescriptionCategoryType::INPROGRESS];
                break;

            case MatchStatusDescriptionCategoryType::FINISHED:
            default:
                $statusCategories = [
                    MatchStatusDescriptionCategoryType::FINISHED,
                    MatchStatusDescriptionCategoryType::CANCELLED,
                    MatchStatusDescriptionCategoryType::UNKNOWN,
                ];
                break;
        }

        $queryBuilder
            ->leftJoin(
                'Visca\Bundle\LicomBundle\Entity\MatchStatusDescription',
                's',
                Join::WITH,
                's.id = m.matchStatusDescription'
            )
            ->andWhere('s.category IN (:categories)')
            ->setParameter('categories', $statusCategories);

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

        if ($competitionRoundId !== null) {
            //            if (is_array($competitionRoundId)) {
            $queryBuilder->andWhere('m.competitionRound IN (:rids)')
                ->setParameter('rids', $competitionRoundId);
//            } elseif (is_numeric($competitionRoundId)) {
//                $queryBuilder->andWhere('m.competitionRound = :rid')
//                    ->setParameter('rid', $competitionRoundId);
//            }
        }

        if ($competitionLegId !== null) {
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
     * @param \DateTime|null $dateFrom               DateTime
     * @param \DateTime|null $dateTo                 DateTime
     * @param string|null    $status                 Status
     * @param array|null     $competitionCategoryIds Status
     *
     * @return array
     */
    public function countMatchesByCompetitionCategorySportAndStatus(
        Sport $sport,
        \DateTime $dateFrom = null,
        \DateTime $dateTo = null,
        $status = null,
        $competitionCategoryIds = null
    ) {
        /*
         * Join to get the Country and MatchStatusDescription
         * To get the countries and the status of the matches.
         *
         * Also is adding the filter by sport.
         */
        $queryBuilder = $this
            ->entityManager
            ->createQueryBuilder()
            ->select('competitionCategory.id', 'count(m.id) as total')
            ->from($this->entityName, 'm')
            // Join with all the classes to get all the data.
            ->join('m.competitionSeasonStage', 'stage')
            ->join('stage.competitionSeason', 'season')
            ->join('season.competition', 'competition')
            ->join('competition.competitionCategory', 'competitionCategory')
            ->join('m.matchStatusDescription', 'matchStatusDescription')
            // Where sport
            ->where('competitionCategory.sport = :sportId')
            ->setParameter('sportId', $sport->getId())
            // Group by Country
            ->addGroupBy('competitionCategory.id');

        // Add the status filter
        if ($status !== null) {
            // Prepare the $status key filter
            switch ($status) {
                case MatchStatusDescriptionCategoryType::INPROGRESS:
                    $statusCategories = [
                        MatchStatusDescriptionCategoryType::INPROGRESS,
                    ];
                    break;

                case MatchStatusDescriptionCategoryType::FINISHED:
                default:
                    $statusCategories = [
                        MatchStatusDescriptionCategoryType::FINISHED,
                        MatchStatusDescriptionCategoryType::CANCELLED,
                        MatchStatusDescriptionCategoryType::UNKNOWN,
                    ];
                    break;
            }

            $queryBuilder
                ->andWhere('matchStatusDescription.category IN (:categories)')
                ->setParameter('categories', $statusCategories);
        }

        // if we have the $competitionCategoryIds filter by id's
        if (!is_null($competitionCategoryIds)) {
            $queryBuilder
                ->andWhere('competitionCategory.id IN (:ccIds)')
                ->setParameter('ccIds', $competitionCategoryIds);
        }

        // Add the filter by date if needed.
        if (!is_null($dateFrom)) {
            $this->alterDateObjects($dateFrom);
            $queryBuilder
                ->andWhere('m.startDate >= :from')
                ->setParameter('from', $dateFrom->format('Y-m-d 00:00:00'));
        }
        if (!is_null($dateTo)) {
            $this->alterDateObjects($dateTo);
            $queryBuilder
                ->andWhere('m.startDate < :to')
                ->setParameter('to', $dateTo->format('Y-m-d 23:59:59'));
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
}
