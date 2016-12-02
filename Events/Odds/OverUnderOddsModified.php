<?php

namespace Visca\Bundle\LicomBundle\Events\Odds;

use Visca\Bundle\LicomBundle\Events\AbstractEvent;
use Visca\Bundle\LicomBundle\Events\Traits\ListenByMatchTrait;

final class OverUnderOddsModified extends AbstractEvent
{
    use ListenByMatchTrait;

    /**
     * @return string
     */
    public function getEventObject()
    {
        return 'over_under_odds';
    }
}
