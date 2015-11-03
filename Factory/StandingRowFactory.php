<?php

namespace Visca\Bundle\LicomBundle\Factory;

use Visca\Bundle\CoreBundle\Factory\Abstracts\AbstractFactory;
use Visca\Bundle\LicomBundle\Entity\StandingRow;

/**
 * Class StandingRowFactory.
 */
class StandingRowFactory extends AbstractFactory
{
    /**
     * @return StandingRow
     */
    public function create()
    {
        $standingRow = new StandingRow();
        $standingRow->setDel('no');

        return $standingRow;
    }
}
