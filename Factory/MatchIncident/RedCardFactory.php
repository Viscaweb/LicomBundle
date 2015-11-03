<?php

namespace Visca\Bundle\LicomBundle\Factory\MatchIncident;

use Visca\Bundle\LicomBundle\Entity\MatchIncident\RedCard;
use Visca\Bundle\LicomBundle\Factory\MatchIncident\Abstracts\AbstractMatchIncidentFactory;

/**
 * Class RedCardFactory.
 */
class RedCardFactory extends AbstractMatchIncidentFactory
{
    /**
     * @return RedCard
     */
    public function create()
    {
        $matchIncident = new RedCard();

        $matchIncident->setIconHTML('<span class="sprite red-card"></span>');

        return $matchIncident;
    }
}
