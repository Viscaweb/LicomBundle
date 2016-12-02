<?php

namespace Visca\Bundle\LicomBundle\Events\Traits;

trait ListenByAthleteTrait
{
    /**
     * @param int $athleteId
     *
     * @return static
     */
    public static function listenByAthlete($athleteId)
    {
        return new static('athlete.'.$athleteId);
    }
}
