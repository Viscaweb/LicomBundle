<?php

namespace Visca\Bundle\LicomBundle\Events\Traits;

trait ListenByMatchTrait
{
    /**
     * @param int $matchId
     *
     * @return static
     */
    public static function listenByMatch($matchId)
    {
        return new static('match.' . $matchId);
    }
}
