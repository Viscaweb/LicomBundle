<?php
namespace Visca\Bundle\LicomBundle\Events\Match;

use Visca\Bundle\LicomBundle\Entity\Athlete;
use Visca\Bundle\LicomBundle\Entity\Competition;
use Visca\Bundle\LicomBundle\Entity\Match as LicomMatch;
use Visca\Bundle\LicomBundle\Entity\Team;
use Visca\Bundle\LicomBundle\Events\AbstractEvent;
use Visca\Bundle\LicomBundle\Events\Event;

class MatchHasBegun extends AbstractEvent implements Event
{
    public function listenByMatch(LicomMatch $match)
    {
        $this->setScope('match.'.$match->getId());

        return $this;
    }

    public function listenByCompetition(Competition $competition)
    {
        $this->setScope('competition.'.$competition->getId());

        return $this;
    }

    public function listenByTeam(Team $team)
    {
        $this->setScope('team.'.$team->getId());

        return $this;
    }

    public function listenByAthlete(Athlete $athlete)
    {
        $this->setScope('athlete.'.$athlete->getId());

        return $this;
    }

    /**
     * @return string
     */
    public function getEventObject()
    {
        return 'match_has_begun';
    }
}