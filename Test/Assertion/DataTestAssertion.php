<?php

namespace Visca\Bundle\LicomBundle\Test\Assertion;

use PHPUnit_Framework_Assert;
use Visca\Bundle\LicomBundle\Entity\Competition;
use Visca\Bundle\LicomBundle\Entity\CompetitionCategory;
use Visca\Bundle\LicomBundle\Entity\CompetitionSeason;
use Visca\Bundle\LicomBundle\Entity\CompetitionSeasonStage;
use Visca\Bundle\LicomBundle\Entity\Country;
use Visca\Bundle\LicomBundle\Entity\Match;
use Visca\Bundle\LicomBundle\Entity\MatchParticipant;
use Visca\Bundle\LicomBundle\Entity\MatchResult;
use Visca\Bundle\LicomBundle\Entity\Participant;

/**
 * Class DataTestAssertion.
 */
class DataTestAssertion extends PHPUnit_Framework_Assert
{
    /**
     * @param Match $match
     */
    public function assertLicomMatchIsValid(Match $match)
    {
        $this->assertNotEmpty($match->getName());

        $matchParticipants = $match->getMatchParticipant();
        $this->assertNotEmpty($matchParticipants);

        foreach ($matchParticipants as $matchParticipant) {
            $this->assertLicomMatchParticipantIsValid($matchParticipant);
        }

        $this->assertLicomCompetitionSeasonStageIsValid(
            $match->getCompetitionSeasonStage()
        );
    }

    /**
     * @param CompetitionSeasonStage $competitionSeasonStage
     */
    public function assertLicomCompetitionSeasonStageIsValid(
        CompetitionSeasonStage $competitionSeasonStage
    ) {
        $this->assertNotNull($competitionSeasonStage->getStart());
        $this->assertNotNull($competitionSeasonStage->getEnd());

        $this->assertLicomCompetitionSeasonIsValid(
            $competitionSeasonStage->getCompetitionSeason()
        );
    }

    /**
     * @param CompetitionSeason $competitionSeason
     */
    public function assertLicomCompetitionSeasonIsValid(
        CompetitionSeason $competitionSeason
    ) {
        $this->assertNotEmpty($competitionSeason->getName());
        $this->assertNotNull($competitionSeason->getStart());
        $this->assertNotNull($competitionSeason->getEnd());

        $this->assertLicomCompetitionIsValid(
            $competitionSeason->getCompetition()
        );
    }

    /**
     * @param Competition $competition
     */
    public function assertLicomCompetitionIsValid(Competition $competition)
    {
        $this->assertNotEmpty($competition->getName());

        $this->assertLicomCompetitionCategoryIsValid(
            $competition->getCompetitionCategory()
        );
    }

    /**
     * @param MatchParticipant $matchParticipant
     */
    public function assertLicomMatchParticipantIsValid(
        MatchParticipant $matchParticipant
    ) {
        $this->assertGreaterThan(0, $matchParticipant->getNumber());

        $this->assertLicomParticipantIsValid(
            $matchParticipant->getParticipant()
        );
    }

    /**
     * @param CompetitionCategory $competitionCategory
     */
    public function assertLicomCompetitionCategoryIsValid(
        CompetitionCategory $competitionCategory
    ) {
        $this->assertNotEmpty($competitionCategory->getName());

        $this->assertLicomCountryIsValid($competitionCategory->getCountry());
    }

    /**
     * @param Country $country
     */
    public function assertLicomCountryIsValid(Country $country)
    {
        $this->assertNotEmpty($country->getName());
    }

    /**
     * @param Participant $participant
     */
    public function assertLicomParticipantIsValid(Participant $participant)
    {
        $this->assertNotEmpty($participant->getName());
    }

    /**
     * @param MatchParticipant $matchParticipant
     */
    public function assertMatchParticipantIsValid(
        MatchParticipant $matchParticipant
    ) {
        $participant = $matchParticipant->getParticipant();

        $this->assertInstanceOf(
            '\Visca\Bundle\LicomBundle\Entity\Team',
            $participant
        );

        $matchResults = $matchParticipant->getMatchResult();

        $this->assertNotEmpty($matchResults);

        foreach ($matchResults as $matchResult) {
            $this->assertMatchResultIsValid($matchResult);
        }
    }

    /**
     * @param MatchResult $matchResult
     */
    public function assertMatchResultIsValid(MatchResult $matchResult)
    {
        /*
         * Stupid test just to make sure we have data
         */
        $matchResultType = $matchResult->getMatchResultType();
        $this->assertInternalType('string', $matchResultType->getCode());
        $this->assertNotEmpty($matchResultType->getCode());
    }
}
