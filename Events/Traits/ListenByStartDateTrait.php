<?php

namespace Visca\Bundle\LicomBundle\Events\Traits;

trait ListenByStartDateTrait
{
    /**
     * @param \DateTime $date
     * @return static
     */
    public static function listenByMatchStartDateHour(\DateTime $date)
    {
        return new static('match_start_date.'.$date->format('Y-m-d-H'));
    }
}