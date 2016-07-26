<?php

namespace Visca\Bundle\LicomBundle\Events\Competition;

use Visca\Bundle\LicomBundle\Events\AbstractEvent;
use Visca\Bundle\LicomBundle\Events\Traits\ListenByCompetitionSeasonStageTrait;
use Visca\Bundle\LicomBundle\Events\Traits\ListenByCompetitionTrait;

final class CompetitionSeasonStage extends AbstractEvent
{
    use ListenByCompetitionSeasonStageTrait, ListenByCompetitionTrait;
    
    /**
     * @return string
     */
    public function getEventObject()
    {
        return 'competition_season_stage';
    }
}
