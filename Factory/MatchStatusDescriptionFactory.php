<?php

namespace Visca\Bundle\LicomBundle\Factory;

use Visca\Bundle\CoreBundle\Factory\Abstracts\AbstractFactory;
use Visca\Bundle\LicomBundle\Entity\MatchStatusDescription;

/**
 * Class MatchStatusDescriptionFactory.
 */
class MatchStatusDescriptionFactory extends AbstractFactory
{
    /**
     * Creates an instance of an entity.
     *
     * @return MatchStatusDescription Empty entity
     */
    public function create()
    {
        $matchStatusDescription = new MatchStatusDescription();
        $matchStatusDescription->setDel('no');

        return $matchStatusDescription;
    }
}
