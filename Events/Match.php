<?php
namespace Visca\Bundle\LicomBundle\Events;

use Visca\Bundle\LicomBundle\Entity\Competition;
use Visca\Bundle\LicomBundle\Entity\CompetitionSeasonStage;
use Visca\Bundle\LicomBundle\Entity\Match as LicomMatch;
use Visca\Bundle\LicomBundle\Entity\Team;

final class Match extends AbstractEvent
{
    public static function listenByMatch(LicomMatch $match)
    {
        return new static('match.'.$match->getId());
    }

    public static function listenByCompetition(Competition $competition)
    {
        return new static('competition.'.$competition->getId());
    }

    public static function listenByCompetitionSeasonStage(
        CompetitionSeasonStage $stage
    ) {
        return new static('competition_season_stage.'.$stage->getId());
    }

    public static function listenByTeam(Team $team)
    {
        return new static('team.'.$team->getId());
    }

    /**
     * @return string
     */
    public function getEventObject()
    {
        return 'match';
    }
}