<?php

namespace Visca\Bundle\LicomBundle\Tests\UnitTest;

use PHPUnit_Framework_TestCase;
use Visca\Bundle\LicomBundle\Entity\Code\MatchStatusDescriptionCode;
use Visca\Bundle\LicomBundle\Entity\Match;
use Visca\Bundle\LicomBundle\Entity\MatchParticipant;
use Visca\Bundle\LicomBundle\Entity\MatchStatusDescription;

/**
 * Class MatchTest.
 */
class MatchTest extends PHPUnit_Framework_TestCase
{
    /**
     * @return array
     */
    public function statusDataProvider()
    {
        return [
            [MatchStatusDescriptionCode::FIRST_HALF_CODE, 'inprogress', true],
            [MatchStatusDescriptionCode::HALFTIME_CODE, 'inprogress', true],
            [MatchStatusDescriptionCode::FINISHED_CODE, 'finished', false],
        ];
    }

    /**
     * Test that isInProgress return valid bool.
     *
     * @dataProvider statusDataProvider
     *
     * @param int    $statusId
     * @param string $statusCategory
     * @param bool   $isInProgress
     */
    public function testIsInProgressMethodReturnValidData(
        $statusId,
        $statusCategory,
        $isInProgress
    ) {
        $status = new MatchStatusDescription();
        $status->setId($statusId);
        $status->setCategory($statusCategory);

        $match = new Match();
        $match->setMatchStatusDescription($status);

        $this->assertEquals($isInProgress, $match->isInProgress());
    }

    /**
     * Test that getHomeParticipant return the home participant.
     */
    public function testGetHomeParticipantReturnTheValidParticipant()
    {
        $matchParticipant = new MatchParticipant();
        $matchParticipant->setNumber(MatchParticipant::HOME);

        $match = new Match();
        $match->addMatchParticipant($matchParticipant);

        $this->assertEquals($match->getHomeParticipant(), $matchParticipant);
    }

    /**
     * Test that getAwayParticipant return the home participant.
     */
    public function testGetAwayParticipantReturnTheValidParticipant()
    {
        $matchParticipant = new MatchParticipant();
        $matchParticipant->setNumber(MatchParticipant::AWAY);

        $match = new Match();
        $match->addMatchParticipant($matchParticipant);

        $this->assertEquals($match->getAwayParticipant(), $matchParticipant);
    }
}
