<?php

namespace Visca\Bundle\LicomBundle\Factory;

use Visca\Bundle\CoreBundle\Factory\Abstracts\AbstractFactory;
use Visca\Bundle\LicomBundle\Entity\MatchAuxProfileType;

/**
 * Class MatchAuxProfileTypeFactory.
 */
class MatchAuxProfileTypeFactory extends AbstractFactory
{
    /**
     * Creates an instance of an entity.
     *
     * @return MatchAuxProfileType Empty entity
     */
    public function create()
    {
        $matchAuxProfileType = new MatchAuxProfileType();
        $matchAuxProfileType
            ->setName('')
            ->setCode('')
            ->setDel('no');

        return $matchAuxProfileType;
    }
}
