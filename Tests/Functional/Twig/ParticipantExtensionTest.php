<?php

namespace Visca\Bundle\LicomViewBundle\Tests\Functional\Twig;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\DomCrawler\Crawler;
use Visca\Bundle\LicomBundle\Entity\Participant;
use Visca\Bundle\LicomViewBundle\Twig\Entity\ParticipantExtension;

/**
 * ParticipantExtensionTest.
 */
class ParticipantExtensionTest extends WebTestCase
{
    /**
     * @var ParticipantExtension
     */
    public $participantExtension;

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
        $this->participantExtension = $kernel->getContainer()->get('visca_licom.twig_extension.entity.participant');
        $this->domain = $kernel->getContainer()->getParameter('licom_domain');
    }

    /**
     * Test tag.
     */
    public function testImgTag()
    {
        $participant = $this->getMock('\Visca\Bundle\LicomBundle\Entity\Participant');
        $participant->expects($this->once())->method('getId')->will($this->returnValue(0));
        /* @var Participant $participant */
        $html = $this->participantExtension->getParticipantIconMedium($participant);
        $crawler = new Crawler($html);
        $this->assertEquals(1, $crawler->filter('img')->count());
    }

    /**
     *  Test source.
     */
    public function testSource()
    {
        $participant = $this->getMock('\Visca\Bundle\LicomBundle\Entity\Participant');
        $participant->expects($this->once())->method('getId')->will($this->returnValue(0));
        /* @var Participant $participant */
        $result = $this->participantExtension->getParticipantIconSourceMedium($participant);
        $this->assertStringStartsWith('http://', $result);
    }
}
