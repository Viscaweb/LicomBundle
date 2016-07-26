<?php

namespace Visca\Bundle\LicomBundle\Events\Traits;

use Visca\Bundle\LicomBundle\Entity\CompetitionStage;

trait ListenByCompetitionStageTrait
{
    /**
     * @param CompetitionStage $stage
     * 
     * @return static
     */
    public static function listenByCompetitionStage(CompetitionStage $stage)
    {
        return new static('competition_stage.'.$stage->getId());
    }
}