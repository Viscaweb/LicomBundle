<?php
namespace Visca\Bundle\LicomBundle\Formatter\Odds\Interfaces;

use Visca\Bundle\LicomBundle\Entity\BettingOffer;

/**
 * Interface OddsFormatterInterface
 */
interface OddsFormatterInterface
{

    /**
     * @param BettingOffer $bettingOffer The offer
     *
     * @return string
     */
    public function formatOdds(BettingOffer $bettingOffer);

}
