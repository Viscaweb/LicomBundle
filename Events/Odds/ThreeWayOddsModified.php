<?php

namespace Visca\Bundle\LicomBundle\Events\Odds;

use Visca\Bundle\LicomBundle\Entity\Match;
use Visca\Bundle\LicomBundle\Events\AbstractEvent;

final class ThreeWayOddsModified extends AbstractEvent
{
    /**
     * @param Match $match
     *
     * @return static
     */
    public static function listenByMatch(Match $match)
    {
        return new static('match.'.$match->getId());
    }

    /**
     * @return string
     */
    public function getEventObject()
    {
        return 'three_way_odds';
    }
}
