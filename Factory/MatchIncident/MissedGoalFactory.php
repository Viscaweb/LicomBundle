<?php

namespace Visca\Bundle\LicomBundle\Factory\MatchIncident;

use Visca\Bundle\LicomBundle\Entity\MatchIncident\MissedGoal;
use Visca\Bundle\LicomBundle\Factory\MatchIncident\Abstracts\AbstractMatchIncidentFactory;

/**
 * Class MissedGoalFactory.
 */
class MissedGoalFactory extends AbstractMatchIncidentFactory
{
    /**
     * @return MissedGoal
     */
    public function create()
    {
        $matchIncident = new MissedGoal();

        $matchIncident->setIconHTML('<span class="sprite missed-goal"></span>');

        return $matchIncident;
    }
}
