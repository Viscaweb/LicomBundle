<?php

namespace Visca\Bundle\LicomBundle\Entity;

use Visca\Bundle\LicomBundle\Factory\TeamFactory;

/**
 * Class Team.
 *
 * Please relate to the parent model: Participant
 */
class Team extends Participant
{
    /**
     * @return Team
     */
    public static function create()
    {
        $factory = new TeamFactory();

        return $factory->create();
    }
}
