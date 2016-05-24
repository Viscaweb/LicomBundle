<?php
namespace Visca\Bundle\LicomBundle\Events\Competition;

use Visca\Bundle\LicomBundle\Events\AbstractEvent;
use Visca\Bundle\LicomBundle\Entity\Competition;
use Visca\Bundle\LicomBundle\Entity\CompetitionStage as LicomCompetitionStage;

class CompetitionStage extends AbstractEvent
{
    public static function listenByCompetitionStage(
        LicomCompetitionStage $stage
    ) {
        return new static('competition_stage.'.$stage->getId());
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
        return 'competition_stage';
    }
}
