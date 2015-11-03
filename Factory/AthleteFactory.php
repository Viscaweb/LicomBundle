<?php

namespace Visca\Bundle\LicomBundle\Factory;

use Visca\Bundle\CoreBundle\Factory\Abstracts\AbstractFactory;
use Visca\Bundle\LicomBundle\Entity\Athlete;

/**
 * Class AthleteFactory.
 */
class AthleteFactory extends AbstractFactory
{
    /**
     * Creates an instance of an entity.
     *
     * @return Athlete Empty entity
     */
    public function create()
    {
        $athlete = new Athlete();
        $athlete
            ->setDel('no')
            ->setToBeConfirmed(false);

        return $athlete;
    }
}
