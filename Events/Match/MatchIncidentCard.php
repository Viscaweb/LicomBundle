<?php
namespace Visca\Bundle\LicomBundle\Events\Match;

use Visca\Bundle\LicomBundle\Entity\Athlete;
use Visca\Bundle\LicomBundle\Entity\Competition;
use Visca\Bundle\LicomBundle\Entity\Match as LicomMatch;
use Visca\Bundle\LicomBundle\Entity\Team;
use Visca\Bundle\LicomBundle\Events\AbstractEvent;

class MatchIncidentCard extends MatchIncident
{
    /**
     * @return string
     */
    public function getEventObject()
    {
        return 'match_incident_card';
    }
}