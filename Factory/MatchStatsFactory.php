<?php

namespace Visca\Bundle\LicomBundle\Factory;

use Visca\Bundle\CoreBundle\Factory\Abstracts\AbstractFactory;
use Visca\Bundle\LicomBundle\Entity\MatchStats;

/**
 * Class MatchStatsFactory.
 */
class MatchStatsFactory extends AbstractFactory
{
    /**
     * Creates an instance of an entity.
     *
     * @return MatchStats Empty entity
     */
    public function create()
    {
        $matchStats = new MatchStats();
        $matchStats
            ->setValue(0)
            ->setDel('no');

        return $matchStats;
    }
}
