<?php
namespace Visca\Bundle\LicomBundle\Events\Match;

use Visca\Bundle\LicomBundle\Entity\Athlete;
use Visca\Bundle\LicomBundle\Entity\Competition;
use Visca\Bundle\LicomBundle\Entity\Match as LicomMatch;
use Visca\Bundle\LicomBundle\Entity\Team;
use Visca\Bundle\LicomBundle\Events\AbstractEvent;

class MatchLineup extends AbstractEvent
{
    public static function listenByMatch(LicomMatch $match)
    {
        return new static('match.'.$match->getId());
    }

    public static function listenByCompetition(Competition $competition)
    {
        return new static('competition.'.$competition->getId());
    }

    public static function listenByTeam(Team $team)
    {
        return new static('team.'.$team->getId());
    }

    public static function listenByAthlete(Athlete $athlete)
    {
        return new static('athlete.'.$athlete->getId());
    }

    /**
     * @return string
     */
    public function getEventObject()
    {
        return 'match_lineup';
    }
}