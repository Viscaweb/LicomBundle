<?php

namespace Visca\Bundle\LicomBundle\Factory;

use Visca\Bundle\CoreBundle\Factory\Abstracts\AbstractFactory;
use Visca\Bundle\LicomBundle\Entity\Team;

/**
 * Class TeamFactory.
 */
class TeamFactory extends AbstractFactory
{
    /**
     * Creates an instance of an entity.
     *
     * @return Team Empty entity
     */
    public function create()
    {
        $team = new Team();
        $team
            ->setDel('no')
            ->setToBeConfirmed(false);

        return $team;
    }
}
