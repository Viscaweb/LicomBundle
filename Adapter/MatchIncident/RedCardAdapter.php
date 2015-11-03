<?php

namespace Visca\Bundle\LicomBundle\Adapter\MatchIncident;

use Visca\Bundle\LicomBundle\Adapter\MatchIncident\Abstracts\AbstractMatchIncidentAdapter;
use Visca\Bundle\LicomBundle\Entity\MatchIncident\RedCard;
use Visca\Bundle\LicomBundle\Factory\MatchIncident\RedCardFactory;

/**
 * Class RedCardAdapter.
 */
class RedCardAdapter extends AbstractMatchIncidentAdapter
{
    /**
     * Adapt the inputObjects to a RedCard entity.
     *
     * @param array $inputObjects
     *
     * @return RedCard
     */
    public function process($inputObjects)
    {
        $factory = new RedCardFactory();
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
