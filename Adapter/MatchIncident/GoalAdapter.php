<?php

namespace Visca\Bundle\LicomBundle\Adapter\MatchIncident;

use Visca\Bundle\LicomBundle\Adapter\MatchIncident\Abstracts\AbstractMatchIncidentAdapter;
use Visca\Bundle\LicomBundle\Entity\MatchIncident\Goal;
use Visca\Bundle\LicomBundle\Factory\MatchIncident\GoalFactory;

/**
 * Class GoalAdapter.
 */
class GoalAdapter extends AbstractMatchIncidentAdapter
{
    /**
     * Adapt the inputObjects to a Goal entity.
     *
     * @param array $inputObjects
     *
     * @return Goal
     */
    public function process($inputObjects)
    {
        $factory = new GoalFactory();
        $finalMatchIncident = $this->create(
            $inputObjects,
            $factory
        );

        return $this->putParticipantInMatchIncident(
            $inputObjects,
            $finalMatchIncident
        );
    }
}
