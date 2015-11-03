<?php

namespace Visca\Bundle\LicomBundle\Adapter\MatchIncident;

use Visca\Bundle\LicomBundle\Adapter\MatchIncident\Abstracts\AbstractMatchIncidentAdapter;
use Visca\Bundle\LicomBundle\Entity\MatchIncident\YellowCard;
use Visca\Bundle\LicomBundle\Factory\MatchIncident\YellowCardFactory;

/**
 * Class YellowCardAdapter.
 */
class YellowCardAdapter extends AbstractMatchIncidentAdapter
{
    /**
     * Adapt the inputObjects to a YellowCard entity.
     *
     * @param array $inputObjects
     *
     * @return YellowCard
     */
    public function process($inputObjects)
    {
        $factory = new YellowCardFactory();
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
