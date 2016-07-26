<?php

namespace Visca\Bundle\LicomBundle\Events\Traits;

use Visca\Bundle\LicomBundle\Entity\Competition;

trait ListenByCompetitionTrait
{
    /**
     * @param Competition $competition
     *
     * @return static
     */
    public static function listenByCompetition(Competition $competition)
    {
        return new static('competition.'.$competition->getId());
    }
}