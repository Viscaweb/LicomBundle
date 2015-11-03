<?php

namespace Visca\Bundle\LicomBundle\Factory\MatchIncident;

use Visca\Bundle\LicomBundle\Entity\MatchIncident\YellowCard;
use Visca\Bundle\LicomBundle\Factory\MatchIncident\Abstracts\AbstractMatchIncidentFactory;

/**
 * Class YellowCardFactory.
 */
class YellowCardFactory extends AbstractMatchIncidentFactory
{
    /**
     * @return YellowCard
     */
    public function create()
    {
        $matchIncident = new YellowCard();

        $matchIncident->setIconHTML('<span class="sprite yellow-card"></span>');

        return $matchIncident;
    }
}
