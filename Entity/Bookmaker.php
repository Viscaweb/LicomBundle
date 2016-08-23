<?php

namespace Visca\Bundle\LicomBundle\Entity;

use Visca\Bundle\CoreBundle\Entity\Traits\OptionalDateTimeTrait;
use Visca\Bundle\CoreBundle\Entity\Traits\DeletableTrait;

/**
 * Bookmaker.
 *
 * The bookmaker are mainly use for the odds sections.
 * Bookmaker (ViscaLicomBundle) and Partner (ViscaPartnerBundle) are NOT the same and can't be mixed.
 *
 * Quantity of data: This model contains a static number of rows.
 *
 * @example Betclic
 * @example Bwin
 * @example Unibet
 */
class Bookmaker
{
    use OptionalDateTimeTrait;
    use DeletableTrait;

    /**
     * @var string
     */
    private $id;

    /**
     * @var string
     */
    private $name;

    /**
     * @var BettingOfferProvider|null
     */
    private $provider;

    /**
     * @var string
     */
    private $url;

    /**
     * Get id.
     *
     * @return string
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set id.
     *
     * @param string $id
     *
     * @return Bookmaker
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
     * @return Bookmaker
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get url.
     *
     * @return string
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * @param BettingOfferProvider $provider
     *
     * @return Bookmaker
     */
    public function setProvider(BettingOfferProvider $provider = null)
    {
        $this->provider = $provider;

        return $this;
    }

    /**
     * @return BettingOfferProvider|null
     */
    public function getProvider()
    {
        return $this->provider;
    }
}
