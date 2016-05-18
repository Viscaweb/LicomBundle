<?php
namespace Visca\Bundle\LicomBundle\Events\Match;

use Visca\Bundle\LicomBundle\Entity\Competition;
use Visca\Bundle\LicomBundle\Entity\Match as LicomMatch;
use Visca\Bundle\LicomBundle\Entity\Team;
use Visca\Bundle\LicomBundle\Events\AbstractEvent;

class MatchStatus extends AbstractEvent
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

    /**
     * @return string
     */
    public function getEventObject()
    {
        return 'match_status';
    }
}