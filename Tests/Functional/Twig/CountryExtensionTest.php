<?php

namespace Visca\Bundle\LicomViewBundle\Tests\Functional\Twig;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\DomCrawler\Crawler;
use Visca\Bundle\LicomBundle\Entity\Country;
use Visca\Bundle\LicomViewBundle\Twig\Entity\CountryExtension;

/**
 * CountryExtensionTest.
 */
class CountryExtensionTest extends WebTestCase
{
    /**
     * @var CountryExtension
     */
    public $countryExtension;

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
        $this->countryExtension = $kernel->getContainer()->get('visca_licom.twig_extension.entity.country');
        $this->domain = $kernel->getContainer()->getParameter('licom_domain');
    }

    /**
     * Test tag.
     */
    public function testImgTag()
    {
        $country = Country::create();
        $country->setCode('de');
        $country->setName('Germany');
        $html = $this->countryExtension->getCountryIconMedium($country);
        $crawler = new Crawler($html);
        $this->assertEquals(1, $crawler->filter('img')->count());
    }

    /**
     *  Test source.
     */
    public function testSource()
    {
        $country = Country::create();

        $result = $this->countryExtension->getCountryIconSourceMedium($country);
        $this->assertStringStartsWith('http://', $result);
    }
}
