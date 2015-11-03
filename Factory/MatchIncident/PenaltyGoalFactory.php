<?php

namespace Visca\Bundle\LicomBundle\Factory\MatchIncident;

use Visca\Bundle\LicomBundle\Entity\MatchIncident\PenaltyGoal;
use Visca\Bundle\LicomBundle\Factory\MatchIncident\Abstracts\AbstractMatchIncidentFactory;

/**
 * Class PenaltyGoalFactory.
 */
class PenaltyGoalFactory extends AbstractMatchIncidentFactory
{
    /**
     * @return PenaltyGoal
     */
    public function create()
    {
        $matchIncident = new PenaltyGoal();

        $matchIncident->setIconHTML('<span class="sprite penalty-goal"></span>');

        return $matchIncident;
    }
}
