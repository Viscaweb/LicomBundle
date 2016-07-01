<?php
namespace Visca\Bundle\LicomBundle\Events\Traits;

use Visca\Bundle\LicomBundle\Entity\Athlete;

trait ListenByAthleteTrait
{
    /**
     * @param Athlete $athlete
     * @return static
     */
    public static function listenByAthlete(Athlete $athlete)
    {
        return new static('athlete.'.$athlete->getId());
    }
}