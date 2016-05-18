<?php
namespace Visca\Bundle\LicomBundle\Events;

use Visca\Bundle\LicomBundle\Entity\Athlete;
use Visca\Bundle\LicomBundle\Entity\Competition;
use Visca\Bundle\LicomBundle\Entity\Match as LicomMatch;
use Visca\Bundle\LicomBundle\Entity\Team;

final class Match extends AbstractEvent implements Event
{
    public static function listenByMatch(LicomMatch $match)
    {
        return self::createSelfByScope('match.'.$match->getId());
    }

    public static function listenByCompetition(Competition $competition)
    {
        return self::createSelfByScope('competition.'.$competition->getId());
    }

    public static function listenByTeam(Team $team)
    {
        return self::createSelfByScope('team.'.$team->getId());
    }

    public static function listenByAthlete(Athlete $athlete)
    {
        return self::createSelfByScope('athlete.'.$athlete->getId());
    }

    /**
     * @return string
     */
    public function getEventObject()
    {
        return 'match';
    }
}
