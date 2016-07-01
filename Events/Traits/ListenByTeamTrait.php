<?php

namespace Visca\Bundle\LicomBundle\Events\Traits;

use Visca\Bundle\LicomBundle\Entity\Team;

trait ListenByTeamTrait
{
    /**
     * @param Team $team
     * @return static
     */
    public static function listenByTeam(Team $team)
    {
        return new static('team.'.$team->getId());
    }
}