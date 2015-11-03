<?php

namespace Visca\Bundle\LicomBundle\Factory;

use Visca\Bundle\CoreBundle\Factory\Abstracts\AbstractFactory;
use Visca\Bundle\LicomBundle\Entity\Standing;

/**
 * Class StandingFactory.
 */
class StandingFactory extends AbstractFactory
{
    /**
     * @return Standing
     */
    public function create()
    {
        $standing = new Standing();
        $standing->setDel('no');

        return $standing;
    }
}
