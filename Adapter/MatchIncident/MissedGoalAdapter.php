<?php

namespace Visca\Bundle\LicomBundle\Adapter\MatchIncident;

use Visca\Bundle\LicomBundle\Adapter\MatchIncident\Abstracts\AbstractMatchIncidentAdapter;
use Visca\Bundle\LicomBundle\Entity\MatchIncident\MissedGoal;
use Visca\Bundle\LicomBundle\Factory\MatchIncident\MissedGoalFactory;

/**
 * Class MissedGoalAdapter.
 */
class MissedGoalAdapter extends AbstractMatchIncidentAdapter
{
    /**
     * Adapt the inputObjects to a MissedGoal entity.
     *
     * @param array $inputObjects
     *
     * @return MissedGoal
     */
    public function process($inputObjects)
    {
        $factory = new MissedGoalFactory();
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
