<?php

namespace Visca\Bundle\LicomBundle\Entity;

use Visca\Bundle\CoreBundle\Entity\Traits\OptionalDateTimeTrait;
use Visca\Bundle\CoreBundle\Entity\Traits\DeletableTrait;

/**
 * BettingOffer.
 *
 * The BettingOffer contains all odds displayed in the website.
 *
 * Quantity of data: This model usually DOES contains a LOT of entries, be careful when querying it.
 *
 * @example Odds 1x2 for the Match 'Juventus - FC Barcelona'
 * @example Odds 1x2 for the Competition 'Ligue 1 FR'.
 * @example Odds over/under about the numbers of goals scored for Match 'Juventus - FC Barcelona'
 *
 * @link http://bit.ly/OddsMatch Odds displayed in LIFE for a given match.
 */
class BettingOffer
{
    use OptionalDateTimeTrait;
    use DeletableTrait;

    /**
     * @var int
     */
    private $id;

    /**
     * @var MatchBettingOutcome
     */
    private $bettingOutcome;

    /**
     * @var BettingOfferProvider
     */
    private $bettingOfferProvider;

    /**
     * @var float
     */
    private $odds;

    /**
     * @var float
     */
    private $oddsOld;

    /**
     * @var bool
     */
    private $valid;

    /**
     * Get id.
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Get MatchBettingOutcome.
     *
     * @return MatchBettingOutcome
     */
    public function getBettingOutcome()
    {
        return $this->bettingOutcome;
    }

    /**
     * Set MatchBettingOutcome.
     *
     * @param MatchBettingOutcome $bettingOutcome
     *
     * @return BettingOffer
     */
    public function setBettingOutcome(
        MatchBettingOutcome $bettingOutcome
    ) {
        $this->bettingOutcome = $bettingOutcome;

        return $this;
    }

    /**
     * Get BettingOfferProvider.
     *
     * @return BettingOfferProvider
     */
    public function getBettingOfferProvider()
    {
        return $this->bettingOfferProvider;
    }

    /**
     * Set BettingOfferProvider.
     *
     * @param BettingOfferProvider $bettingOfferProvider
     *
     * @return BettingOffer
     */
    public function setBettingOfferProvider(
        BettingOfferProvider $bettingOfferProvider
    ) {
        $this->bettingOfferProvider = $bettingOfferProvider;

        return $this;
    }

    /**
     * Get odds.
     *
     * @return float
     */
    public function getOdds()
    {
        return $this->odds;
    }

    /**
     * Set odds.
     *
     * @param float $odds
     *
     * @return BettingOffer
     */
    public function setOdds($odds)
    {
        $this->odds = $odds;

        return $this;
    }

    /**
     * Get odds_old.
     *
     * @return float
     */
    public function getOddsOld()
    {
        return $this->oddsOld;
    }

    /**
     * Set odds_old.
     *
     * @param float $oddsOld
     *
     * @return BettingOffer
     */
    public function setOddsOld($oddsOld)
    {
        $this->oddsOld = $oddsOld;

        return $this;
    }

    /**
     * Get valid.
     *
     * @return bool
     */
    public function isValid()
    {
        return $this->valid;
    }

    /**
     * Set valid.
     *
     * @param bool $valid
     *
     * @return BettingOffer
     */
    public function setValid($valid)
    {
        $this->valid = $valid;

        return $this;
    }
}
