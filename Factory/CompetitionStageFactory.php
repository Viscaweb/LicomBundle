<?php

namespace Visca\Bundle\LicomBundle\Factory;

use Visca\Bundle\CoreBundle\Factory\Abstracts\AbstractFactory;
use Visca\Bundle\LicomBundle\Entity\CompetitionStage;

/**
 * Class CompetitionStageFactory.
 */
class CompetitionStageFactory extends AbstractFactory
{
    /**
     * Creates an instance of an entity.
     *
     * @return CompetitionStage Empty entity
     */
    public function create()
    {
        $competitionStage = new CompetitionStage();
        $competitionStage->setDel('no');

        return $competitionStage;
    }
}
