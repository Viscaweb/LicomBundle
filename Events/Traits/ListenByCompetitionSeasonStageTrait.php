<?php

namespace Visca\Bundle\LicomBundle\Events\Traits;

use Visca\Bundle\LicomBundle\Entity\CompetitionSeasonStage;

trait ListenByCompetitionSeasonStageTrait
{
    /**
     * @param CompetitionSeasonStage $competitionSeasonStage
     *
     * @return static
     */
    public static function listenByCompetitionSeasonStage(CompetitionSeasonStage $competitionSeasonStage)
    {
        return new static('competition_season_stage.'.$competitionSeasonStage->getId());
    }
}
