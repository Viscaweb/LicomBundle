<?php

namespace Visca\Bundle\LicomBundle\Events\Traits;

trait ListenByCompetitionSeasonStageTrait
{
    /**
     * @param int $competitionSeasonStageId
     *
     * @return static
     */
    public static function listenByCompetitionSeasonStage($competitionSeasonStageId)
    {
        return new static('competition_season_stage.'.$competitionSeasonStageId);
    }
}
