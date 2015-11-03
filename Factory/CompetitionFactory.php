<?php

namespace Visca\Bundle\LicomBundle\Factory;

use Visca\Bundle\CoreBundle\Factory\Abstracts\AbstractFactory;
use Visca\Bundle\LicomBundle\Entity\Competition;

/**
 * Class CompetitionFactory.
 */
class CompetitionFactory extends AbstractFactory
{
    /**
     * Creates an instance of an entity.
     *
     * @return Competition Empty entity
     */
    public function create()
    {
        $competition = new Competition();
        $competition->setDel('no');

        return $competition;
    }
}
