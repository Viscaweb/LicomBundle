<?php

namespace Visca\Bundle\LicomBundle\Factory;

use Visca\Bundle\CoreBundle\Factory\Abstracts\AbstractFactory;
use Visca\Bundle\LicomBundle\Entity\MatchStatsType;

/**
 * Class MatchStatsTypeFactory.
 */
class MatchStatsTypeFactory extends AbstractFactory
{
    /**
     * Creates an instance of an entity.
     *
     * @return MatchStatsType Empty entity
     */
    public function create()
    {
        $matchStatsType = new MatchStatsType();
        $matchStatsType
            ->setCode('')
            ->setName('')
            ->setDel('no');

        return $matchStatsType;
    }
}
