<?php

namespace Visca\Bundle\LicomViewBundle\Provider\Image;

use Visca\Bundle\LicomBundle\Entity\Country;
use Visca\Bundle\LicomViewBundle\Provider\Image\Abstracts\AbstractImageProvider;

/**
 * CountryImageProvider.
 */
class CountryImageProvider extends AbstractImageProvider
{
    const ENTITY_NAME = 'country';

    /**
     * @var Country Country entity
     */
    protected $country;

    /**
     * @param Country $country country
     *
     * @return $this
     */
    public function setCountry(Country $country)
    {
        $this->country = $country;

        return $this;
    }

    /**
     * @return string
     */
    public function getDescription()
    {
        return $this->country->getName();
    }

    /**
     * @return string
     */
    public function getImageName()
    {
        return $this->country->getCode();
    }
}
