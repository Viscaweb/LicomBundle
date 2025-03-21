<?php

namespace Visca\Bundle\LicomBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Visca\Bundle\CoreBundle\Entity\Traits\OptionalDateTimeTrait;
use Visca\Bundle\CoreBundle\Entity\Traits\DeletableTrait;

/**
 * BettingOfferProvider.
 *
 * Many bookmakers are using the odds suggested by a provider.
 * This is not an information we usually display in the websites.
 *
 * Quantity of data: This model contains a static number of rows.
 */
class BettingOfferProvider
{
    use OptionalDateTimeTrait;
    use DeletableTrait;

    /**
     * @var int
     */
    private $id;

    /**
     * @var string
     */
    private $name;

    /**
     * @var BettingOffer[]
     */
    private $bettingOffers;

    /** @var Bookmaker[] */
    private $bookmakers;

    /**
     * BettingOfferProvider constructor.
     */
    public function __construct()
    {
        $this->bettingOffers = new ArrayCollection();
        $this->bookmakers = new ArrayCollection();
    }


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
     * Set id.
     *
     * @param int $id
     *
     * @return BettingOfferProvider
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Get name.
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set name.
     *
     * @param string $name
     *
     * @return BettingOfferProvider
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return BettingOffer[]
     */
    public function getBettingOffers()
    {
        return $this->bettingOffers;
    }

    /**
     * @param BettingOffer[] $bettingOffers
     *
     * @return BettingOfferProvider
     */
    public function setBettingOffers($bettingOffers)
    {
        $this->bettingOffers = $bettingOffers;

        return $this;
    }

    /**
     * @return Bookmaker[]
     */
    public function getBookmakers()
    {
        return $this->bookmakers;
    }

    /**
     * @param Bookmaker[] $bookmakers
     *
     * @return BettingOfferProvider
     */
    public function setBookmakers($bookmakers)
    {
        $this->bookmakers = $bookmakers;

        return $this;
    }
}
