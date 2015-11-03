<?php

namespace Visca\Bundle\LicomBundle\Factory;

use Visca\Bundle\CoreBundle\Factory\Abstracts\AbstractFactory;
use Visca\Bundle\LicomBundle\Entity\CompetitionSeason;

/**
 * Class CompetitionSeasonFactory.
 */
class CompetitionSeasonFactory extends AbstractFactory
{
    /**
     * Creates an instance of an entity.
     *
     * @return CompetitionSeason Empty entity
     */
    public function create()
    {
        $competitionSeason = new CompetitionSeason();
        $competitionSeason->setDel('no');

        return $competitionSeason;
    }
}
