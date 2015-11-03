<?php

namespace Visca\Bundle\LicomBundle\Factory\MatchIncident;

use Visca\Bundle\LicomBundle\Entity\MatchIncident\Goal;
use Visca\Bundle\LicomBundle\Factory\MatchIncident\Abstracts\AbstractMatchIncidentFactory;

/**
 * Class GoalFactory.
 */
class GoalFactory extends AbstractMatchIncidentFactory
{
    /**
     * @return Goal
     */
    public function create()
    {
        $matchIncident = new Goal();

        $matchIncident->setIconHTML('<span class="sprite goal"></span>');

        return $matchIncident;
    }
}
