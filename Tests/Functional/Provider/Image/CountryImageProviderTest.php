<?php

namespace Visca\Bundle\LicomViewBundle\Tests\Functional\Provider\Image;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Visca\Bundle\LicomBundle\Entity\Country;
use Visca\Bundle\LicomViewBundle\Provider\Image\CountryImageProvider;

/**
 * CountryImageProviderTest.
 */
class CountryImageProviderTest extends WebTestCase
{
    /**
     * @var CountryImageProvider
     */
    public $countryImageProvider;

    /**
     * @var string
     */
    public $defaultFolder;

    /**
     * @var string
     */
    public $domain;

    /**
     * setUp().
     */
    public function setUp()
    {
        $kernel = static::createKernel();
        $kernel->boot();
        $this->countryImageProvider = $kernel->getContainer()->get('visca_licom.provider.image.country');
        $this->defaultFolder = $kernel->getContainer()->getParameter('visca.media.adapter.filesystem.default_folder');
        $this->domain = $kernel->getContainer()->getParameter('licom_domain');
    }

    /**
     * Test image exists.
     */
    public function testImageExistsTrue()
    {
        $country = Country::create();
        $country->setCode('de');
        $this->countryImageProvider->setCountry($country);
        $result = $this->countryImageProvider->getImageUrl();
        $imagePath = sprintf(
            'http://%s/%s/%s/m/%s.%s',
            $this->domain,
            $this->defaultFolder,
            strtolower(CountryImageProvider::ENTITY_NAME),
            $country->getCode(),
            CountryImageProvider::IMAGE_EXTENSION
        );
        $this->assertEquals($imagePath, $result);
        $media = $this->countryImageProvider->getMedia();
        $this->assertInstanceOf('Visca\Bundle\MediaBundle\Model\Media', $media);
    }

    /**
     * Test country not exists.
     */
    public function testCountryNotExistsTrue()
    {
        $country = Country::create();
        $country->setCode('xx');
        $this->countryImageProvider->setCountry($country);
        $result = $this->countryImageProvider->getImageUrl();
        $imagePath = sprintf(
            'http://%s/%s/%s/m/%s.%s',
            $this->domain,
            $this->defaultFolder,
            strtolower(CountryImageProvider::ENTITY_NAME),
            CountryImageProvider::DEFAULT_IMAGE_NAME,
            CountryImageProvider::IMAGE_EXTENSION
        );
        $this->assertEquals($imagePath, $result);
        $media = $this->countryImageProvider->getMedia();
        $this->assertInstanceOf('Visca\Bundle\MediaBundle\Model\Media', $media);
    }

    /**
     *  Test size not exists.
     */
    public function testSizeNotExists()
    {
        $country = Country::create();
        $country->setCode('0');
        $this->countryImageProvider->setCountry($country);
        $this->countryImageProvider->setSize('not exists');
        $result = $this->countryImageProvider->getImageUrl();
        $this->assertFalse($result);

        $media = $this->countryImageProvider->getMedia();
        $this->assertFalse($media);
    }
}
