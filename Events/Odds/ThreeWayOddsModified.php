<?php

namespace Visca\Bundle\LicomBundle\Events\Odds;

use Visca\Bundle\LicomBundle\Entity\Match;
use Visca\Bundle\LicomBundle\Events\AbstractEvent;
use Visca\Bundle\LicomBundle\Events\Traits\ListenByMatchTrait;

final class ThreeWayOddsModified extends AbstractEvent
{
    use ListenByMatchTrait;

    /**
     * @return string
     */
    public function getEventObject()
    {
        return 'three_way_odds';
    }
}
