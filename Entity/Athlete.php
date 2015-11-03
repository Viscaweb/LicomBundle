<?php

namespace Visca\Bundle\LicomBundle\Entity;

use Visca\Bundle\LicomBundle\Factory\AthleteFactory;
use Visca\Bundle\LicomBundle\Entity\Traits\AthleteTrait;

/**
 * Class Athlete.
 *
 * Please relate to the parent model: Participant
 */
class Athlete extends Participant
{
    use AthleteTrait;

    /**
     * @return Athlete
     */
    public static function create()
    {
        $factory = new AthleteFactory();

        return $factory->create();
    }
}
