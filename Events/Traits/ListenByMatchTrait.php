<?php

namespace Visca\Bundle\LicomBundle\Events\Traits;

use Visca\Bundle\LicomBundle\Entity\Match;

trait ListenByMatchTrait
{
    /**
     * @param Match $match
     * @return static
     */
    public static function listenByMatch(Match $match)
    {
        return new static('match.'.$match->getId());
    }
}