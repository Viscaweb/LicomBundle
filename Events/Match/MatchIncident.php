<?php

namespace Visca\Bundle\LicomBundle\Events\Match;

use Visca\Bundle\LicomBundle\Events\AbstractEvent;
use Visca\Bundle\LicomBundle\Events\Traits\ListenByAthleteTrait;
use Visca\Bundle\LicomBundle\Events\Traits\ListenByCompetitionTrait;
use Visca\Bundle\LicomBundle\Events\Traits\ListenByMatchTrait;
use Visca\Bundle\LicomBundle\Events\Traits\ListenByStartDateTrait;
use Visca\Bundle\LicomBundle\Events\Traits\ListenByTeamTrait;

final class MatchIncident extends AbstractEvent
{
    use ListenByMatchTrait, ListenByTeamTrait, ListenByAthleteTrait, ListenByCompetitionTrait, ListenByStartDateTrait;

    /**
     * @return string
     */
    public function getEventObject()
    {
        return 'match_incident';
    }
}
