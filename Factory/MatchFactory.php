<?php

namespace Visca\Bundle\LicomBundle\Factory;

use Visca\Bundle\CoreBundle\Factory\Abstracts\AbstractFactory;
use Visca\Bundle\LicomBundle\Entity\Match;

/**
 * Class MatchFactory.
 */
class MatchFactory extends AbstractFactory
{
    /**
     * Creates an instance of an entity.
     *
     * @return Match Empty entity
     */
    public function create()
    {
        $match = new Match();
        $match->setDel('no');

        return $match;
    }
}
