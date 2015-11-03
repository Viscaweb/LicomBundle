<?php

namespace Visca\Bundle\LicomViewBundle\Tests\Functional\Twig;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\DomCrawler\Crawler;
use Visca\Bundle\LicomBundle\Entity\Sport;
use Visca\Bundle\LicomViewBundle\Twig\Entity\SportExtension;

/**
 * SportExtensionTest.
 */
class SportExtensionTest extends WebTestCase
{
    /**
     * @var SportExtension
     */
    public $sportExtension;

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
        $this->sportExtension = $kernel->getContainer()->get('visca_licom.twig_extension.entity.sport');
        $this->domain = $kernel->getContainer()->getParameter('licom_domain');
    }

    /**
     * Test tag.
     */
    public function testImgTag()
    {
        $sport = $this->getMock('\Visca\Bundle\LicomBundle\Entity\Sport');
        $sport->expects($this->once())->method('getId')->will($this->returnValue(0));
        /* @var Sport $sport */
        $html = $this->sportExtension->getSportIconMedium($sport);
        $crawler = new Crawler($html);
        $this->assertEquals(1, $crawler->filter('img')->count());
    }
    /**
     *  Test source.
     */
    public function testSource()
    {
        $sport = $this->getMock('\Visca\Bundle\LicomBundle\Entity\Sport');
        $sport->expects($this->once())->method('getId')->will($this->returnValue(0));
        /* @var Sport $sport */
        $result = $this->sportExtension->getSportIconSourceMedium($sport);
        $this->assertStringStartsWith('http://', $result);
    }
}
