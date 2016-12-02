<?php

namespace Visca\Bundle\LicomBundle\Events\Traits;

trait ListenByCompetitionLegTrait
{
    /**
     * @param int $leg
     *
     * @return static
     */
    public static function listenByCompetitionLeg($legId)
    {
        return new static('competition_leg.'.$legId);
    }
}
