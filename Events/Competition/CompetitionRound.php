<?php
namespace Visca\Bundle\LicomBundle\Events\Competition;

use Visca\Bundle\LicomBundle\Events\AbstractEvent;
use Visca\Bundle\LicomBundle\Entity\Competition;
use Visca\Bundle\LicomBundle\Entity\CompetitionRound as LicomCompetitionRound;

class CompetitionRound extends AbstractEvent
{
    public static function listenByCompetitionRound(
        LicomCompetitionRound $round
    ) {
        return new static('competition_round.'.$round->getId());
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
        return 'competition_round';
    }
}
