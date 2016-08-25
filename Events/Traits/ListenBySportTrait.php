<?php

namespace Visca\Bundle\LicomBundle\Events\Traits;

use Visca\Bundle\LicomBundle\Entity\Sport;

trait ListenBySportTrait
{
    /**
     * @param Sport $sport
     *
     * @return static
     */
    public static function listenBySport(Sport $sport)
    {
        return new static('sport.'.$sport->getId());
    }
}
