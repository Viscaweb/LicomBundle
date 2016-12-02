<?php

namespace Visca\Bundle\LicomBundle\Events\Traits;

trait ListenByCompetitionStageTrait
{
    /**
     * @param int $stageId
     *
     * @return static
     */
    public static function listenByCompetitionStage($stageId)
    {
        return new static('competition_stage.'.$stageId);
    }
}
