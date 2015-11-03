<?php

namespace Visca\Bundle\LicomBundle\Factory;

use Visca\Bundle\CoreBundle\Factory\Abstracts\AbstractFactory;
use Visca\Bundle\LicomBundle\Entity\StandingCell;

/**
 * Class StandingCellFactory.
 */
class StandingCellFactory extends AbstractFactory
{
    /**
     * @return StandingCell
     */
    public function create()
    {
        $standingCell = new StandingCell();
        $standingCell->setDel('no');

        return $standingCell;
    }
}
