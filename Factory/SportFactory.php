<?php

namespace Visca\Bundle\LicomBundle\Factory;

use Visca\Bundle\CoreBundle\Factory\Abstracts\AbstractFactory;
use Visca\Bundle\LicomBundle\Entity\Sport;

/**
 * Class SportFactory.
 */
class SportFactory extends AbstractFactory
{
    /**
     * @return Sport
     */
    public function create()
    {
        $sport = new Sport();
        $sport->setDel('no');

        return $sport;
    }
}
