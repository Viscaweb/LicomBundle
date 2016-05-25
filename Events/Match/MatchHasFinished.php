<?php
namespace Visca\Bundle\LicomBundle\Events\Match;

use Visca\Bundle\LicomBundle\Entity\Athlete;
use Visca\Bundle\LicomBundle\Entity\Competition;
use Visca\Bundle\LicomBundle\Entity\CompetitionSeasonStage;
use Visca\Bundle\LicomBundle\Entity\Match as LicomMatch;
use Visca\Bundle\LicomBundle\Entity\Team;
use Visca\Bundle\LicomBundle\Entity\Sport;
use Visca\Bundle\LicomBundle\Events\AbstractEvent;
use Visca\Bundle\LicomBundle\Events\Event;

/**
 * Class MatchHasFinished
 * @package Visca\Bundle\LicomBundle\Events\Match
 */
class MatchHasFinished extends AbstractEvent
{
    /**
     * @param LicomMatch $match
     *
     * @return static
     */
    public static function listenByMatch(LicomMatch $match)
    {
        return new static('match.'.$match->getId());
    }

    /**
     * @param Competition $competition
     *
     * @return static
     */
    public static function listenByCompetition(Competition $competition)
    {
        return new static('competition.'.$competition->getId());
    }

    /**
     * @param CompetitionSeasonStage $competitionSeasonStage
     *
     * @return static
     */
    public static function listenByCompetitionSeasonStage(CompetitionSeasonStage $competitionSeasonStage)
    {
        return new static('competition_season_stage.'.$competitionSeasonStage->getId());
    }

    /**
     * @param Team $team
     *
     * @return static
     */
    public static function listenByTeam(Team $team)
    {
        return new static('team.'.$team->getId());
    }

    /**
     * @param Sport $sport
     *
     * @return static
     */
    public static function listenBySport(Sport $sport)
    {
        return new static('sport.'.$sport->getId());
    }

    /**
     * @return string
     */
    public function getEventObject()
    {
        return 'match_has_finished';
    }
}