<?php

namespace Visca\Bundle\LicomBundle\Events\Competition;

use Visca\Bundle\LicomBundle\Events\AbstractEvent;
use Visca\Bundle\LicomBundle\Events\Traits\ListenByCompetitionRoundTrait;
use Visca\Bundle\LicomBundle\Events\Traits\ListenByCompetitionTrait;

final class CompetitionRound extends AbstractEvent
{
    use ListenByCompetitionRoundTrait, ListenByCompetitionTrait;

    /**
     * @return string
     */
    public function getEventObject()
    {
        return 'competition_round';
    }
}
