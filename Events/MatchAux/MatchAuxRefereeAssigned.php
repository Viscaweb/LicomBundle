<?php

namespace Visca\Bundle\LicomBundle\Events\MatchAux;

use Visca\Bundle\LicomBundle\Events\AbstractEvent;
use Visca\Bundle\LicomBundle\Events\Traits\ListenByMatchTrait;

final class MatchAuxRefereeAssigned extends AbstractEvent
{
    use ListenByMatchTrait;

    /**
     * @return string
     */
    public function getEventObject()
    {
        return 'match_aux_referee_assigned';
    }
}
