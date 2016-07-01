<?php

namespace Visca\Bundle\LicomBundle\Events\Competition;

use Visca\Bundle\LicomBundle\Events\AbstractEvent;
use Visca\Bundle\LicomBundle\Events\Traits\ListenByCompetitionLegTrait;
use Visca\Bundle\LicomBundle\Events\Traits\ListenByCompetitionStageTrait;

final class CompetitionStage extends AbstractEvent
{
    use ListenByCompetitionStageTrait, ListenByCompetitionLegTrait;

    /**
     * @return string
     */
    public function getEventObject()
    {
        return 'competition_stage';
    }
}
