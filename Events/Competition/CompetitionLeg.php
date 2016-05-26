<?php
namespace Visca\Bundle\LicomBundle\Events\Competition;

use Visca\Bundle\LicomBundle\Entity\Competition;
use Visca\Bundle\LicomBundle\Entity\CompetitionLeg as LicomCompetitionLeg;
use Visca\Bundle\LicomBundle\Events\AbstractEvent;

/**
 * Class CompetitionLeg
 */
class CompetitionLeg extends AbstractEvent
{
    /**
     * @param LicomCompetitionLeg $round
     *
     * @return static
     */
    public static function listenByCompetitionLeg(LicomCompetitionLeg $leg)
    {
        return new static('competition_leg.'.$leg->getId());
    }

    /**
     * @param Competition $competition
     *
     * @return static
     */
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
