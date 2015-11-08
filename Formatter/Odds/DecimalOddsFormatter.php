<?php

namespace Visca\Bundle\LicomBundle\Formatter\Odds;

use Visca\Bundle\LicomBundle\Entity\BettingOffer;
use Visca\Bundle\LicomBundle\Formatter\Odds\Interfaces\OddsFormatterInterface;

/**
 * Class DecimalOddsFormatter
 */
class DecimalOddsFormatter implements OddsFormatterInterface
{
    /**
     * @param BettingOffer $bettingOffer The offer
     *
     * @return string
     */
    public function formatOdds(BettingOffer $bettingOffer)
    {
        // TODO: Implement formatOdds() method.
    }

}