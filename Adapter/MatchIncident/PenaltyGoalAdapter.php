<?php

namespace Visca\Bundle\LicomBundle\Adapter\MatchIncident;

use Visca\Bundle\LicomBundle\Adapter\MatchIncident\Abstracts\AbstractMatchIncidentAdapter;
use Visca\Bundle\LicomBundle\Entity\MatchIncident\PenaltyGoal;
use Visca\Bundle\LicomBundle\Factory\MatchIncident\PenaltyGoalFactory;

/**
 * Class PenaltyGoalAdapter.
 */
class PenaltyGoalAdapter extends AbstractMatchIncidentAdapter
{
    /**
     * Adapt the inputObjects to a PenaltyGoal entity.
     *
     * @param array $inputObjects
     *
     * @return PenaltyGoal
     */
    public function process($inputObjects)
    {
        $factory = new PenaltyGoalFactory();
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
