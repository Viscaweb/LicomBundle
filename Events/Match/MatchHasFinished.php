<?php

namespace Visca\Bundle\LicomBundle\Events\Match;

use Visca\Bundle\LicomBundle\Events\AbstractEvent;
use Visca\Bundle\LicomBundle\Events\Traits\ListenByCompetitionSeasonStageTrait;
use Visca\Bundle\LicomBundle\Events\Traits\ListenByCompetitionTrait;
use Visca\Bundle\LicomBundle\Events\Traits\ListenByMatchTrait;
use Visca\Bundle\LicomBundle\Events\Traits\ListenBySportTrait;
use Visca\Bundle\LicomBundle\Events\Traits\ListenByTeamTrait;


final class MatchHasFinished extends AbstractEvent
{
    use ListenByMatchTrait, ListenByTeamTrait, ListenBySportTrait, ListenByCompetitionTrait, ListenByCompetitionSeasonStageTrait;

    /**
     * @return string
     */
    public function getEventObject()
    {
        return 'match_has_finished';
    }
}