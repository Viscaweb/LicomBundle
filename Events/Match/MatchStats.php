<?php

namespace Visca\Bundle\LicomBundle\Events\Match;

use Visca\Bundle\LicomBundle\Events\AbstractEvent;
use Visca\Bundle\LicomBundle\Events\Traits\ListenByCompetitionTrait;
use Visca\Bundle\LicomBundle\Events\Traits\ListenByMatchTrait;
use Visca\Bundle\LicomBundle\Events\Traits\ListenByTeamTrait;

final class MatchStats extends AbstractEvent
{
    use ListenByMatchTrait, ListenByCompetitionTrait, ListenByTeamTrait;

    /**
     * @return string
     */
    public function getEventObject()
    {
        return 'match_stats';
    }
}
