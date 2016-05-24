<?php
namespace Visca\Bundle\LicomBundle\Events\Competition;

use Visca\Bundle\LicomBundle\Events\AbstractEvent;
use Visca\Bundle\LicomBundle\Entity\Competition;
use Visca\Bundle\LicomBundle\Entity\CompetitionLeg as LicomCompetitionLeg;

class CompetitionLeg extends AbstractEvent
{
    public static function listenByCompetitionLeg(
        LicomCompetitionLeg $round
    ) {
        return new static('competition_leg.'.$round->getId());
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
        return 'competition_leg';
    }
}
