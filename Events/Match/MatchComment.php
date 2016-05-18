<?php
namespace Visca\Bundle\LicomBundle\Events\Match;

use Visca\Bundle\LicomBundle\Events\AbstractEvent;
use Visca\Bundle\LicomBundle\Entity\Match as LicomMatch;
use Visca\Bundle\LicomBundle\Entity\Team;

class MatchComment extends AbstractEvent
{
    public static function listenByMatch(LicomMatch $match)
    {
        return self::createSelfByScope('match.'.$match->getId());
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
        return 'match_comment';
    }
}