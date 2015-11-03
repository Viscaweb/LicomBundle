<?php

namespace Visca\Bundle\LicomBundle\Factory;

use Visca\Bundle\CoreBundle\Factory\Abstracts\AbstractFactory;
use Visca\Bundle\LicomBundle\Entity\CompetitionStageType;

/**
 * Class CompetitionStageTypeFactory.
 */
class CompetitionStageTypeFactory extends AbstractFactory
{
    /**
     * Creates an instance of an entity.
     *
     * @return CompetitionStageType Empty entity
     */
    public function create()
    {
        $competitionStageType = new CompetitionStageType();
        $competitionStageType->setDel('no');

        return $competitionStageType;
    }
}
