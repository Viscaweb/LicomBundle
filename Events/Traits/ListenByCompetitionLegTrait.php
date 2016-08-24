<?php

namespace Visca\Bundle\LicomBundle\Events\Traits;

use Visca\Bundle\LicomBundle\Entity\CompetitionLeg;

trait ListenByCompetitionLegTrait
{
    /**
     * @param LicomCompetitionLeg $leg
     *
     * @return static
     */
    public static function listenByCompetitionLeg(CompetitionLeg $leg)
    {
        return new static('competition_leg.'.$leg->getId());
    }
}
