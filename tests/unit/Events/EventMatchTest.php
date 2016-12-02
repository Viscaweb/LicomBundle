<?php

use Visca\Bundle\LicomBundle\Entity\Athlete;
use Visca\Bundle\LicomBundle\Entity\Competition;
use Visca\Bundle\LicomBundle\Entity\CompetitionSeasonStage;
use Visca\Bundle\LicomBundle\Entity\Match;
use Visca\Bundle\LicomBundle\Entity\Sport;
use Visca\Bundle\LicomBundle\Entity\Team;
use Visca\Bundle\LicomBundle\Events;
use Visca\Bundle\LicomBundle\Events\Event;
use Visca\Bundle\LicomBundle\Events\Match as MatchEvent;

/**
 * Class EventMatchTest.
 */
class EventMatchTest extends PHPUnit_Framework_TestCase
{
    /**
     * @param string $listenTo
     * @param string $listenBy
     * @param mixed  $object
     * @param string $expectedEventName
     *
     * @dataProvider listOfEvents
     */
    public function test($listenTo, $listenBy, $object, $expectedEventName)
    {
        /** @var Event $event */
        $event = $listenTo::$listenBy($object);
        $this->assertEquals($event->getName(), $expectedEventName);
    }

    /**
     * @return array
     */
    public function listOfEvents()
    {
        $matchEvent = '\Visca\Bundle\LicomBundle\Events\Match';
        $matchResultEvent = '\Visca\Bundle\LicomBundle\Events\Match\MatchResult';
        $matchIncidentEvent = '\Visca\Bundle\LicomBundle\Events\Match\MatchIncident';
        $matchCardEvent = '\Visca\Bundle\LicomBundle\Events\Match\MatchIncidentCard';
        $matchCommentEvent = '\Visca\Bundle\LicomBundle\Events\Match\MatchComment';
        $matchStatsEvent = '\Visca\Bundle\LicomBundle\Events\Match\MatchStats';
        $matchLineupEvent = '\Visca\Bundle\LicomBundle\Events\Match\MatchLineup';
        $matchHasBegunEvent = '\Visca\Bundle\LicomBundle\Events\Match\MatchHasBegun';
        $matchHasFinishedEvent = '\Visca\Bundle\LicomBundle\Events\Match\MatchHasFinished';

        $matchRefereeAssignedEvent = Events\MatchAux\MatchAuxRefereeAssigned::class;
        $matchIncidentAssitsEvent = MatchEvent\MatchIncidentAssist::class;
        $matchIncidentSubstitutionEvent = MatchEvent\MatchIncidentSubstitution::class;
        $matchIncidentRegularGoalEvent = MatchEvent\MatchIncidentRegularGoal::class;
        $matchIncidentRegularPenaltyScoredEvent = MatchEvent\MatchIncidentRegularPenaltyScored::class;
        $matchIncidentRegularPenaltyMissedEvent = MatchEvent\MatchIncidentRegularPenaltyMissed::class;
        $matchIncidentOwnGoalEvent = MatchEvent\MatchIncidentOwnGoal::class;

        $matchImportantAssigned = Events\MatchAuxProfile\MatchImportantAssigned::class;
        $matchCommentedCoverageAssigned = Events\MatchAuxProfile\MatchCommentedCoverageAssigned::class;

        $listenByCompSS = 'listenByCompetitionSeasonStage';

        return [
            // Match
            [$matchEvent, 'listenByMatch', 1, 'match@match.1'],
            [$matchEvent, 'listenByCompetition', 1, 'match@competition.1'],
            [$matchEvent, $listenByCompSS, 1, 'match@competition_season_stage.1'],
            [$matchEvent, 'listenByTeam', 1, 'match@team.1'],
            [$matchEvent, 'listenByMatchStartDateHour', new \DateTime('1991-03-07 18:00:00'), 'match@match_start_date.1991-03-07-18'],

            // MatchResult
            [$matchResultEvent, 'listenByMatch', 1, 'match_result@match.1'],
            [$matchResultEvent, 'listenByCompetition', 1, 'match_result@competition.1'],
            [$matchResultEvent, 'listenByTeam', 1, 'match_result@team.1'],
            [$matchResultEvent, 'listenByMatchStartDateHour', new \DateTime('1991-03-07 18:00:00'), 'match_result@match_start_date.1991-03-07-18'],

            // MatchIncident
            [$matchIncidentEvent, 'listenByMatch', 1, 'match_incident@match.1'],
            [$matchIncidentEvent, 'listenByCompetition', 1, 'match_incident@competition.1'],
            [$matchIncidentEvent, 'listenByTeam', 1, 'match_incident@team.1'],
            [$matchIncidentEvent, 'listenByAthlete', 1, 'match_incident@athlete.1'],
            [$matchIncidentEvent, 'listenByMatchStartDateHour', new \DateTime('1991-03-07 18:00:00'), 'match_incident@match_start_date.1991-03-07-18'],

            // MatchCard
            [$matchCardEvent, 'listenByMatch', 1, 'match_incident_card@match.1'],
            [$matchCardEvent, 'listenByCompetition', 1, 'match_incident_card@competition.1'],
            [$matchCardEvent, 'listenByTeam', 1, 'match_incident_card@team.1'],
            [$matchCardEvent, 'listenByAthlete', 1, 'match_incident_card@athlete.1'],
            [$matchCardEvent, 'listenByMatchStartDateHour', new \DateTime('1991-03-07 18:00:00'), 'match_incident_card@match_start_date.1991-03-07-18'],

            // MatchComment
            [$matchCommentEvent, 'listenByMatch', 1, 'match_comment@match.1'],

            // MatchHasBegun
            [$matchHasBegunEvent, 'listenByMatch', 1, 'match_has_begun@match.1'],
            [$matchHasBegunEvent, 'listenByCompetition', 1, 'match_has_begun@competition.1'],
            [
                $matchHasBegunEvent,
                $listenByCompSS,
                1,
                'match_has_begun@competition_season_stage.1',
            ],
            [$matchHasBegunEvent, 'listenByTeam', 1, 'match_has_begun@team.1'],
            [$matchHasBegunEvent, 'listenBySport', 1, 'match_has_begun@sport.1'],

            // MatchHasFinished
            [$matchHasFinishedEvent, 'listenByMatch', 1, 'match_has_finished@match.1'],
            [
                $matchHasFinishedEvent,
                'listenByCompetition',
                1,
                'match_has_finished@competition.1',
            ],
            [
                $matchHasFinishedEvent,
                $listenByCompSS,
                1,
                'match_has_finished@competition_season_stage.1',
            ],
            [$matchHasFinishedEvent, 'listenByTeam', 1, 'match_has_finished@team.1'],
            [$matchHasFinishedEvent, 'listenBySport', 1, 'match_has_finished@sport.1'],

            // MatchStats
            [$matchStatsEvent, 'listenByMatch', 1, 'match_stats@match.1'],
            [$matchStatsEvent, 'listenByCompetition', 1, 'match_stats@competition.1'],
            [$matchStatsEvent, 'listenByTeam', 1, 'match_stats@team.1'],

            // MatchLineup
            [$matchLineupEvent, 'listenByMatch', 1, 'match_lineup@match.1'],
            [$matchLineupEvent, 'listenByCompetition', 1, 'match_lineup@competition.1'],
            [$matchLineupEvent, 'listenByTeam', 1, 'match_lineup@team.1'],
            [$matchLineupEvent, 'listenByAthlete', 1, 'match_lineup@athlete.1'],

            // MatchRefereeAssignedEvent
            [$matchRefereeAssignedEvent, 'listenByMatch', 1, 'match_aux_referee_assigned@match.1'],

            // MatchRefereeAssignedEvent
            [$matchIncidentAssitsEvent, 'listenByMatch', 1, 'match_incident_assist@match.1'],
            [$matchIncidentAssitsEvent, 'listenByTeam', 1, 'match_incident_assist@team.1'],
            [$matchIncidentAssitsEvent, 'listenByAthlete', 1, 'match_incident_assist@athlete.1'],

            // MatchIncidentSubstitutionEvent
            [
                $matchIncidentSubstitutionEvent,
                'listenByMatch',
                1,
                'match_incident_substitution@match.1'
            ],
            [
                $matchIncidentSubstitutionEvent,
                'listenByTeam',
                1,
                'match_incident_substitution@team.1'
            ],
            [
                $matchIncidentSubstitutionEvent,
                'listenByAthlete',
                1,
                'match_incident_substitution@athlete.1'
            ],

            // MatchIncidentRegularGoalEvent
            [
                $matchIncidentRegularGoalEvent,
                'listenByMatch',
                1,
                'match_incident_regular_goal@match.1'
            ],
            [
                $matchIncidentRegularGoalEvent,
                'listenByTeam',
                1,
                'match_incident_regular_goal@team.1'
            ],
            [
                $matchIncidentRegularGoalEvent,
                'listenByAthlete',
                1,
                'match_incident_regular_goal@athlete.1'
            ],

            // MatchIncidentRegularPenaltyScoredEvent
            [
                $matchIncidentRegularPenaltyScoredEvent,
                'listenByMatch',
                1,
                'match_incident_regular_penalty_scored@match.1'
            ],
            [
                $matchIncidentRegularPenaltyScoredEvent,
                'listenByTeam',
                1,
                'match_incident_regular_penalty_scored@team.1'
            ],
            [
                $matchIncidentRegularPenaltyScoredEvent,
                'listenByAthlete',
                1,
                'match_incident_regular_penalty_scored@athlete.1'
            ],

            // MatchIncidentRegularPenaltyMissedEvent
            [
                $matchIncidentRegularPenaltyMissedEvent,
                'listenByMatch',
                1,
                'match_incident_regular_penalty_missed@match.1'
            ],
            [
                $matchIncidentRegularPenaltyMissedEvent,
                'listenByTeam',
                1,
                'match_incident_regular_penalty_missed@team.1'
            ],
            [
                $matchIncidentRegularPenaltyMissedEvent,
                'listenByAthlete',
                1,
                'match_incident_regular_penalty_missed@athlete.1'
            ],

            // MatchIncidentOwnGoalEvent
            [$matchIncidentOwnGoalEvent, 'listenByMatch', 1, 'match_incident_own_goal@match.1'],
            [$matchIncidentOwnGoalEvent, 'listenByTeam', 1, 'match_incident_own_goal@team.1'],
            [
                $matchIncidentOwnGoalEvent,
                'listenByAthlete',
                1,
                'match_incident_own_goal@athlete.1'
            ],


            // MatchImportantAssigned
            [
                $matchImportantAssigned,
                'listenByMatch',
                1,
                'match_aux_profile_match_important_assigned@match.1'
            ],
            [
                $matchImportantAssigned,
                'listenBySport',
                1,
                'match_aux_profile_match_important_assigned@sport.1'
            ],


            // MatchImportantAssigned
            [
                $matchCommentedCoverageAssigned,
                'listenByMatch',
                1,
                'match_aux_profile_match_commented_coverage_assigned@match.1'
            ],
            [
                $matchCommentedCoverageAssigned,
                'listenBySport',
                1,
                'match_aux_profile_match_commented_coverage_assigned@sport.1'
            ],
        ];
    }

    /**
     * @param int $competitionSeasonStageId
     *
     * @return CompetitionSeasonStage
     */
    private function createCompetitionSeasonStage($competitionSeasonStageId)
    {
        $competitionSeasonStageObj = new CompetitionSeasonStage();
        $this->setId($competitionSeasonStageObj, $competitionSeasonStageId);

        return $competitionSeasonStageObj;
    }

    /**
     * @param mixed $object
     * @param int   $id
     */
    private function setId($object, $id)
    {
        $objReflected = new ReflectionClass($object);
        $idProperty = $objReflected->getProperty('id');
        $idProperty->setAccessible(true);
        $idProperty->setValue($object, $id);
    }
}
