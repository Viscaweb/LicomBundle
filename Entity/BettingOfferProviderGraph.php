<?php

namespace Visca\Bundle\LicomBundle\Entity;

use Visca\Bundle\CoreBundle\Entity\Traits\DeletableTrait;

/**
 * BettingOfferProviderGraph.
 *
 * This model make the relationship between the providers and the bookmakers.
 */
class BettingOfferProviderGraph
{
    use DeletableTrait;

    /**
     * @var BettingOfferProvider
     */
    private $bettingOfferProvider;

    /**
     * @var BettingOfferProviderGraphLabel
     */
    private $label;

    /**
     * @var Bookmaker
     */
    private $bookmaker;

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
     * @return BettingOfferProviderGraph
     */
    public function setBettingOfferProvider(
        BettingOfferProvider $bettingOfferProvider
    ) {
        $this->bettingOfferProvider = $bettingOfferProvider;

        return $this;
    }

    /**
     * Get label.
     *
     * @return BettingOfferProviderGraphLabel
     */
    public function getLabel()
    {
        return $this->label;
    }

    /**
     * Set label.
     *
     * @param BettingOfferProviderGraphLabel $label
     *
     * @return BettingOfferProviderGraph
     */
    public function setLabel(BettingOfferProviderGraphLabel $label)
    {
        $this->label = $label;

        return $this;
    }

    /**
     * Get Bookmaker.
     *
     * @return int
     */
    public function getBookmaker()
    {
        return $this->bookmaker;
    }

    /**
     * Set Bookmaker.
     *
     * @param Bookmaker $bookmaker
     *
     * @return BettingOfferProviderGraph
     */
    public function setBookmaker(Bookmaker $bookmaker)
    {
        $this->bookmaker = $bookmaker;

        return $this;
    }
}
