<?php
namespace Visca\Bundle\LicomBundle\Events\Competition;

use Visca\Bundle\LicomBundle\Events\AbstractEvent;
use Visca\Bundle\LicomBundle\Entity\Competition;
use Visca\Bundle\LicomBundle\Entity\CompetitionSeasonStage as LicomCompetitionSeasonStage;

class CompetitionSeasonStage extends AbstractEvent
{
    public static function listenByCompetitionSeasonStage(
        LicomCompetitionSeasonStage $stage
    ) {
        return new static('competition_season_stage.'.$stage->getId());
    }

    public static function listenByCompetition(Competition $competition)
    {
        return new static('competition.'.$competition->getId());
    }

    /**
     * @return string
     */
    public function getEventObject()
    {
        return 'competition_season_stage';
    }
}
