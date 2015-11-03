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
     * @var int
     */
    private $id;

    /**
     * @var string
     */
    private $name;

    /**
     * @var string
     */
    private $url;

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
     * Set url.
     *
     * @param string $url
     *
     * @return Bookmaker
     */
    public function setUrl($url)
    {
        $this->url = $url;

        return $this;
    }
}
