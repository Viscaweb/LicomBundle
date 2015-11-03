<?php

namespace Visca\Bundle\LicomBundle\Factory;

use Visca\Bundle\CoreBundle\Factory\Abstracts\AbstractFactory;
use Visca\Bundle\LicomBundle\Entity\CompetitionCategory;

/**
 * Class CompetitionCategoryFactory.
 */
class CompetitionCategoryFactory extends AbstractFactory
{
    /**
     * Creates an instance of an entity.
     *
     * @return CompetitionCategory Empty entity
     */
    public function create()
    {
        $competitionCategory = new CompetitionCategory();
        $competitionCategory->setDel('no');

        return $competitionCategory;
    }
}
