<?php

namespace Visca\Bundle\LicomViewBundle\Twig\Entity;

use Visca\Bundle\LicomBundle\Entity\Country;
use Visca\Bundle\LicomViewBundle\Provider\Image\CountryImageProvider;
use Visca\Bundle\MediaBundle\Twig\Abstracts\AbstractTwigExtension;

/**
 * Class CountryExtension.
 */
class CountryExtension extends AbstractTwigExtension
{
    /**
     * @var CountryImageProvider
     */
    protected $imageProvider;

    /**
     * Constructor.
     *
     * @param CountryImageProvider $countryImageProvider CountryImageProvider
     */
    public function __construct(
        CountryImageProvider $countryImageProvider
    ) {
        parent::__construct($countryImageProvider);
    }

    /**
     * {@inheritdoc}
     */
    public function getFunctions()
    {
        return [
            new \Twig_SimpleFunction(
                'country_icon_small',
                [$this, 'getCountryIconSmall'],
                ['is_safe' => ['html']]
            ),
            new \Twig_SimpleFunction(
                'country_icon_medium',
                [$this, 'getCountryIconMedium'],
                ['is_safe' => ['html']]
            ),
            new \Twig_SimpleFunction(
                'country_icon_source_small',
                [$this, 'getCountryIconSourceSmall']
            ),
            new \Twig_SimpleFunction(
                'country_icon_source_medium',
                [$this, 'getCountryIconSourceMedium']
            ),
        ];
    }

    /**
     * @param Country $country Country object
     *
     * @return bool|string
     */
    public function getCountryIconSmall(Country $country)
    {
        return $this->getCountryIcon($country, 's');
    }

    /**
     * @param Country $country Country object
     *
     * @return bool|string
     */
    public function getCountryIconSourceSmall(Country $country)
    {
        return $this->getCountryIconSource($country, 'm');
    }

    /**
     * @param Country $country Country object
     *
     * @return bool|string
     */
    public function getCountryIconSourceMedium(Country $country)
    {
        return $this->getCountryIconSource($country, 'm');
    }

    /**
     * @param Country $country Country object
     *
     * @return bool|string
     */
    public function getCountryIconMedium(Country $country)
    {
        return $this->getCountryIcon($country, 'm');
    }

    /**
     * @param Country $country Country object
     * @param string  $size    size
     *
     * @return bool|string
     */
    private function getCountryIcon(
        Country $country,
        $size
    ) {
        $this->imageProvider
            ->setCountry($country)
            ->setSize($size);
        $media = $this->imageProvider->getMedia();

        return $this->getIcon($media);
    }

    /**
     * @param Country $country Country object
     * @param string  $size    size
     *
     * @return string
     */
    private function getCountryIconSource(
        Country $country,
        $size
    ) {
        $this->imageProvider
            ->setCountry($country)
            ->setSize($size);
        $media = $this->imageProvider->getMedia();

        return $this->getSource($media);
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'visca_licom_extension_entity_country';
    }
}
