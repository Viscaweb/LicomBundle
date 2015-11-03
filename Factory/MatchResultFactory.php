<?php

namespace Visca\Bundle\LicomBundle\Factory;

use Visca\Bundle\CoreBundle\Factory\Abstracts\AbstractFactory;
use Visca\Bundle\LicomBundle\Entity\MatchResult;

/**
 * Class MatchResultFactory.
 */
class MatchResultFactory extends AbstractFactory
{
    /**
     * Creates an instance of an entity.
     *
     * @return MatchResult Empty entity
     */
    public function create()
    {
        $matchResult = new MatchResult();
        $matchResult->setDel('no');

        return $matchResult;
    }
}
