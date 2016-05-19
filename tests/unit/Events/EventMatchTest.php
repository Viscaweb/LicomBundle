<?php

use Visca\Bundle\LicomBundle\Entity\Athlete;
use Visca\Bundle\LicomBundle\Entity\Competition;
use Visca\Bundle\LicomBundle\Entity\Match;
use Visca\Bundle\LicomBundle\Entity\Team;
use Visca\Bundle\LicomBundle\Events\Event;
use \Visca\Bundle\LicomBundle\Events\Match as MatchEvent;

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

        return [
            // Match
            [$matchEvent,         'listenByMatch',       $this->createMatch(1),       'match@match.1'],
            [$matchEvent,         'listenByCompetition', $this->createCompetition(1), 'match@competition.1'],
            [$matchEvent,         'listenByTeam',        $this->createTeam(1),        'match@team.1'],

            // MatchResult
            [$matchResultEvent,   'listenByMatch',       $this->createMatch(1),       'match_result@match.1'],
            [$matchResultEvent,   'listenByCompetition', $this->createCompetition(1), 'match_result@competition.1'],
            [$matchResultEvent,   'listenByTeam',        $this->createTeam(1),        'match_result@team.1'],

            // MatchIncident
            [$matchIncidentEvent, 'listenByMatch',       $this->createMatch(1),       'match_incident@match.1'],
            [$matchIncidentEvent, 'listenByCompetition', $this->createCompetition(1), 'match_incident@competition.1'],
            [$matchIncidentEvent, 'listenByTeam',        $this->createTeam(1),        'match_incident@team.1'],
            [$matchIncidentEvent, 'listenByAthlete',     $this->createAthlete(1),     'match_incident@athlete.1'],

            // MatchCard
            [$matchCardEvent,     'listenByMatch',       $this->createMatch(1),       'match_incident_card@match.1'],
            [$matchCardEvent,     'listenByCompetition', $this->createCompetition(1), 'match_incident_card@competition.1'],
            [$matchCardEvent,     'listenByTeam',        $this->createTeam(1),        'match_incident_card@team.1'],
            [$matchCardEvent,     'listenByAthlete',     $this->createAthlete(1),     'match_incident_card@athlete.1'],

            // MatchComment
            [$matchCommentEvent,  'listenByMatch',       $this->createMatch(1),       'match_comment@match.1'],

            // MatchHasBegun
            [$matchHasBegunEvent, 'listenByMatch',       $this->createMatch(1),       'match_has_begun@match.1'],
            [$matchHasBegunEvent, 'listenByCompetition', $this->createCompetition(1), 'match_has_begun@competition.1'],
            [$matchHasBegunEvent, 'listenByTeam',        $this->createTeam(1),        'match_has_begun@team.1'],

            // MatchStats
            [$matchStatsEvent,    'listenByMatch',       $this->createMatch(1),       'match_stats@match.1'],
            [$matchStatsEvent,    'listenByCompetition', $this->createCompetition(1), 'match_stats@competition.1'],
            [$matchStatsEvent,    'listenByTeam',        $this->createTeam(1),        'match_stats@team.1'],

            // MatchLineup
            [$matchLineupEvent,   'listenByMatch',       $this->createMatch(1),       'match_lineup@match.1'],
            [$matchLineupEvent,   'listenByCompetition', $this->createCompetition(1), 'match_lineup@competition.1'],
            [$matchLineupEvent,   'listenByTeam',        $this->createTeam(1),        'match_lineup@team.1'],
            [$matchLineupEvent,   'listenByAthlete',     $this->createAthlete(1),     'match_lineup@athlete.1'],
        ];
    }

    /**
     * @param int $athleteId
     *
     * @return Team
     */
    private function createAthlete($athleteId)
    {
        $athleteObj = new Athlete();
        $this->setId($athleteObj, $athleteId);

        return $athleteObj;
    }

    /**
     * @param int $teamId
     *
     * @return Team
     */
    private function createTeam($teamId)
    {
        $teamObj = new Team();
        $this->setId($teamObj, $teamId);

        return $teamObj;
    }

    /**
     * @param int $competitionId
     *
     * @return Match
     */
    private function createCompetition($competitionId)
    {
        $competitionObj = new Competition();
        $this->setId($competitionObj, $competitionId);

        return $competitionObj;
    }

    /**
     * @param $matchId
     *
     * @return Match
     */
    private function createMatch($matchId)
    {
        $matchObj = new Match();
        $this->setId($matchObj, $matchId);

        return $matchObj;
    }

    /**
     * @param mixed $object
     * @param int $id
     */
    private function setId($object, $id)
    {
        $objReflected = new ReflectionClass($object);
        $idProperty = $objReflected->getProperty('id');
        $idProperty->setAccessible(true);
        $idProperty->setValue($object, $id);
    }
}

