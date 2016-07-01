<?php

namespace Visca\Bundle\LicomBundle\Events;

use Visca\Bundle\LicomBundle\Events\Traits\ListenByCompetitionTrait;

final class Competition extends AbstractEvent
{
    use ListenByCompetitionTrait;

    /**
     * @return string
     */
    public function getEventObject()
    {
        return 'competition';
    }
}
