<?php

namespace Visca\Bundle\LicomBundle\Factory;

use Visca\Bundle\CoreBundle\Factory\Abstracts\AbstractFactory;
use Visca\Bundle\LicomBundle\Entity\CompetitionSeasonStage;

/**
 * Class CompetitionSeasonStageFactory.
 */
class CompetitionSeasonStageFactory extends AbstractFactory
{
    /**
     * Creates an instance of an entity.
     *
     * @return CompetitionSeasonStage Empty entity
     */
    public function create()
    {
        $competitionSeasonStage = new CompetitionSeasonStage();
        $competitionSeasonStage->setDel('no');

        return $competitionSeasonStage;
    }
}
