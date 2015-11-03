<?php

namespace Visca\Bundle\LicomBundle\Factory;

use Visca\Bundle\CoreBundle\Factory\Abstracts\AbstractFactory;
use Visca\Bundle\LicomBundle\Entity\MatchIncident;

/**
 * Class MatchIncidentFactory.
 */
class MatchIncidentFactory extends AbstractFactory
{
    /**
     * Creates an instance of an entity.
     *
     * @return MatchIncident Empty entity
     */
    public function create()
    {
        $matchIncident = new MatchIncident();
        $matchIncident->setDel('no');

        return $matchIncident;
    }
}
