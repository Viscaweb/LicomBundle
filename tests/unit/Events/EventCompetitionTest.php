<?php

use Visca\Bundle\LicomBundle\Entity\Competition;
use Visca\Bundle\LicomBundle\Entity\CompetitionRound;
use Visca\Bundle\LicomBundle\Entity\CompetitionSeasonStage;
use Visca\Bundle\LicomBundle\Entity\CompetitionStage;
use Visca\Bundle\LicomBundle\Entity\CompetitionLeg;
use Visca\Bundle\LicomBundle\Events\Event;

/**
 * Class EventCompetitionTest.
 */
class EventCompetitionTest extends PHPUnit_Framework_TestCase
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
        $competitionEvent = '\Visca\Bundle\LicomBundle\Events\Competition';
        $competitionSeasonStageEvent = '\Visca\Bundle\LicomBundle\Events\Competition\CompetitionSeasonStage';
        $competitionRoundEvent = '\Visca\Bundle\LicomBundle\Events\Competition\CompetitionRound';
        $competitionLegEvent = '\Visca\Bundle\LicomBundle\Events\Competition\CompetitionLeg';
        $competitionStageEvent = '\Visca\Bundle\LicomBundle\Events\Competition\CompetitionStage';

        return [
            // Competition
            [$competitionEvent,            'listenByCompetition',            1, 'competition@competition.1'],

            // CompetitionStage
            [$competitionStageEvent,       'listenByCompetition',            1, 'competition_stage@competition.1'],
            [$competitionStageEvent,       'listenByCompetitionLeg',         1, 'competition_stage@competition_leg.1'],
            [$competitionStageEvent,       'listenByCompetitionStage',       1, 'competition_stage@competition_stage.1'],

            // CompetitionRound
            [$competitionRoundEvent,       'listenByCompetition',            1, 'competition_round@competition.1'],
            [$competitionRoundEvent,       'listenByCompetitionRound',       1, 'competition_round@competition_round.1'],

            // CompetitionLeg
            [$competitionLegEvent,         'listenByCompetition',            1, 'competition_leg@competition.1'],
            [$competitionLegEvent,         'listenByCompetitionLeg',         1, 'competition_leg@competition_leg.1'],

            // CompetitionSeasonStage
            [$competitionSeasonStageEvent, 'listenByCompetition',            1, 'competition_season_stage@competition.1'],
            [$competitionSeasonStageEvent, 'listenByCompetitionSeasonStage', 1, 'competition_season_stage@competition_season_stage.1'],
        ];
    }
}
