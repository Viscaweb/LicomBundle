<?php

namespace Visca\Bundle\LicomBundle\Events\Match;

use Visca\Bundle\LicomBundle\Events\AbstractEvent;
use Visca\Bundle\LicomBundle\Entity\Match as LicomMatch;
use Visca\Bundle\LicomBundle\Events\Traits\ListenByMatchTrait;

final class MatchRefereeAssigned extends AbstractEvent
{
    use ListenByMatchTrait;

    /**
     * @return string
     */
    public function getEventObject()
    {
        return 'match_referee_assigned';
    }
}