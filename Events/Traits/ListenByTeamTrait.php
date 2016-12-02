<?php

namespace Visca\Bundle\LicomBundle\Events\Traits;

trait ListenByTeamTrait
{
    /**
     * @param int $teamId
     *
     * @return static
     */
    public static function listenByTeam($teamId)
    {
        return new static('team.'.$teamId);
    }
}
