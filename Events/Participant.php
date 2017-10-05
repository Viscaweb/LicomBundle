<?php

namespace Visca\Bundle\LicomBundle\Events;

use Visca\Bundle\LicomBundle\Events\Traits\ListenBySportTrait;

final class Participant extends AbstractEvent
{
    use ListenBySportTrait;

    /**
     * @return string
     */
    public function getEventObject()
    {
        return 'participant';
    }
}
