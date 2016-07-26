<?php

namespace Visca\Bundle\LicomBundle\Events;

use Visca\Bundle\LicomBundle\Events\Traits\ListenByCompetitionSeasonStageTrait;
use Visca\Bundle\LicomBundle\Events\Traits\ListenByCompetitionTrait;
use Visca\Bundle\LicomBundle\Events\Traits\ListenByMatchTrait;
use Visca\Bundle\LicomBundle\Events\Traits\ListenByTeamTrait;

final class Match extends AbstractEvent
{
    use ListenByMatchTrait, ListenByCompetitionTrait, ListenByCompetitionSeasonStageTrait, ListenByTeamTrait;

    /**
     * @return string
     */
    public function getEventObject()
    {
        return 'match';
    }
}
