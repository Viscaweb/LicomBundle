<?php

use Visca\Bundle\LicomBundle\Entity\Competition;
use Visca\Bundle\LicomBundle\Entity\CompetitionRound;
use Visca\Bundle\LicomBundle\Entity\CompetitionSeasonStage;
use Visca\Bundle\LicomBundle\Entity\CompetitionStage;
use Visca\Bundle\LicomBundle\Events\Event;
use \Visca\Bundle\LicomBundle\Events\Match as MatchEvent;

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

    public function listOfEvents()
    {
        $competitionEvent = '\Visca\Bundle\LicomBundle\Events\Competition';
        $competitionSeasonStageEvent = '\Visca\Bundle\LicomBundle\Events\Competition\CompetitionSeasonStage';
        $competitionRoundEvent = '\Visca\Bundle\LicomBundle\Events\Competition\CompetitionRound';
        $competitionStageEvent = '\Visca\Bundle\LicomBundle\Events\Competition\CompetitionStage';

        return [
            // Competition
            [$competitionEvent,            'listenByCompetition',            $this->createCompetition(1),            'competition@competition.1'],

            // CompetitionStage
            [$competitionStageEvent,       'listenByCompetition',            $this->createCompetition(1),            'competition_stage@competition.1'],
            [$competitionStageEvent,       'listenByCompetitionStage',       $this->createCompetitionStage(1),       'competition_stage@competition_stage.1'],

            // CompetitionRound
            [$competitionRoundEvent,       'listenByCompetition',            $this->createCompetition(1),            'competition_round@competition.1'],
            [$competitionRoundEvent,       'listenByCompetitionRound',       $this->createCompetitionRound(1),       'competition_round@competition_round.1'],

            // CompetitionSeasonStage
            [$competitionSeasonStageEvent, 'listenByCompetition',            $this->createCompetition(1),            'competition_season_stage@competition.1'],
            [$competitionSeasonStageEvent, 'listenByCompetitionSeasonStage', $this->createCompetitionSeasonStage(1), 'competition_season_stage@competition_season_stage.1'],
        ];
    }

    /**
     * @param int $competitionId
     *
     * @return Competition
     */
    private function createCompetition($competitionId)
    {
        $competitionObj = new Competition();
        $this->setId($competitionObj, $competitionId);

        return $competitionObj;
    }

    /**
     * @param int $competitionStageId
     *
     * @return CompetitionStage
     */
    private function createCompetitionStage($competitionStageId)
    {
        $competitionStageObj = new CompetitionStage();
        $this->setId($competitionStageObj, $competitionStageId);

        return $competitionStageObj;
    }

    /**
     * @param int $competitionRoundId
     *
     * @return CompetitionRound
     */
    private function createCompetitionRound($competitionRoundId)
    {
        $competitionRoundObj = new CompetitionRound();
        $this->setId($competitionRoundObj, $competitionRoundId);

        return $competitionRoundObj;
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

