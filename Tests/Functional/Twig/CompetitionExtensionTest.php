<?php

namespace Visca\Bundle\LicomViewBundle\Tests\Functional\Twig;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\DomCrawler\Crawler;
use Visca\Bundle\LicomBundle\Entity\Competition;
use Visca\Bundle\LicomViewBundle\Twig\Entity\CompetitionExtension;

/**
 * CompetitionExtensionTest.
 */
class CompetitionExtensionTest extends WebTestCase
{
    /**
     * @var CompetitionExtension
     */
    public $competitionExtension;

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
        $this->competitionExtension = $kernel->getContainer()->get('visca_licom.twig_extension.entity.competition');
        $this->domain = $kernel->getContainer()->getParameter('licom_domain');
    }

    /**
     * Test tag.
     */
    public function testImgTag()
    {
        $competition = $this->getMock('\Visca\Bundle\LicomBundle\Entity\Competition');
        $competition->expects($this->once())->method('getId')->will($this->returnValue(0));
        /* @var Competition $competition */
        $html = $this->competitionExtension->getCompetitionIconMedium($competition);
        $crawler = new Crawler($html);
        $this->assertEquals(1, $crawler->filter('img')->count());
    }

    /**
     *  Test source.
     */
    public function testSource()
    {
        $competition = $this->getMock('\Visca\Bundle\LicomBundle\Entity\Competition');
        $competition->expects($this->once())->method('getId')->will($this->returnValue(0));
        /* @var Competition $competition */
        $result = $this->competitionExtension->getCompetitionIconSourceMedium($competition);
        $this->assertStringStartsWith('http://', $result);
    }
}
