<?php

namespace Visca\Bundle\LicomBundle\Events\Standing;

use Visca\Bundle\LicomBundle\Events\AbstractEvent;
use Visca\Bundle\LicomBundle\Events\Traits\ListenByCompetitionSeasonStageTrait;
use Visca\Bundle\LicomBundle\Events\Traits\ListenByCompetitionTrait;

final class Standing extends AbstractEvent
{
    use ListenByCompetitionTrait, ListenByCompetitionSeasonStageTrait;

    /**
     * @return string
     */
    public function getEventObject()
    {
        return 'standing';
    }
}
