<?php

namespace Visca\Bundle\LicomBundle\Factory\MatchIncident;

use Visca\Bundle\LicomBundle\Entity\MatchIncident\PlayerChange;
use Visca\Bundle\LicomBundle\Factory\MatchIncident\Abstracts\AbstractMatchIncidentFactory;

/**
 * Class PlayerChangeFactory.
 */
class PlayerChangeFactory extends AbstractMatchIncidentFactory
{
    /**
     * @return PlayerChange
     */
    public function create()
    {
        $matchIncident = new PlayerChange();

        $matchIncident->setIconHTML('<span class="sprite player-change"></span>');

        return $matchIncident;
    }
}
