<?php

namespace Visca\Bundle\LicomBundle\Factory\MatchPeriod;

use Visca\Bundle\LicomBundle\Entity\MatchPeriod\Period;

/**
 * Class PeriodFactory.
 */
class PeriodFactory extends AbstractMatchPeriodFactory
{
    /**
     * Create a MatchPeriod for Period and fill default values.
     *
     * @return Period
     */
    public function create()
    {
        $matchPeriod = new Period();

        return $matchPeriod;
    }
}
