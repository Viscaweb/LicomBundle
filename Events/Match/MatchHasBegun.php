<?php
namespace Visca\Bundle\LicomBundle\Events\Match;

use Visca\Bundle\LicomBundle\Entity\Athlete;
use Visca\Bundle\LicomBundle\Entity\Competition;
use Visca\Bundle\LicomBundle\Entity\Match as LicomMatch;
use Visca\Bundle\LicomBundle\Entity\Team;
use Visca\Bundle\LicomBundle\Events\AbstractEvent;
use Visca\Bundle\LicomBundle\Events\Event;

class MatchHasBegun extends AbstractEvent
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

    /**
     * @return string
     */
    public function getEventObject()
    {
        return 'match_has_begun';
    }
}