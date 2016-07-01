<?php

namespace Visca\Bundle\LicomBundle\Events\Competition;

use Visca\Bundle\LicomBundle\Events\AbstractEvent;
use Visca\Bundle\LicomBundle\Events\Traits\ListenByCompetitionLegTrait;
use Visca\Bundle\LicomBundle\Events\Traits\ListenByCompetitionTrait;

final class CompetitionLeg extends AbstractEvent
{
    use ListenByCompetitionLegTrait, ListenByCompetitionTrait;
    
    /**
     * @return string
     */
    public function getEventObject()
    {
        return 'competition_leg';
    }
}
