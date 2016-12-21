<?php

namespace Visca\Bundle\LicomBundle\Events\Standings;

use Visca\Bundle\LicomBundle\Events\AbstractEvent;
use Visca\Bundle\LicomBundle\Events\Traits\ListenByCompetitionSeasonStageTrait;
use Visca\Bundle\LicomBundle\Events\Traits\ListenByCompetitionTrait;

final class LiveStanding extends AbstractEvent
{
    use ListenByCompetitionTrait, ListenByCompetitionSeasonStageTrait;

    /**
     * @return string
     */
    public function getEventObject()
    {
        return 'live_standings';
    }
}
