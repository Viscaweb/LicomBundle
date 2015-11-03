<?php

namespace Visca\Bundle\LicomViewBundle\Tests\Functional\Provider\Image;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Visca\Bundle\LicomBundle\Entity\Competition;
use Visca\Bundle\LicomViewBundle\Provider\Image\CompetitionImageProvider;

/**
 * CompetitionImageProviderTest.
 */
class CompetitionImageProviderTest extends WebTestCase
{
    /**
     * @var CompetitionImageProvider
     */
    public $competitionImageProvider;

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
        $this->competitionImageProvider = $kernel->getContainer()->get('visca_licom.provider.image.competition');
        $this->defaultFolder = $kernel->getContainer()->getParameter('visca.media.adapter.filesystem.default_folder');
        $this->domain = $kernel->getContainer()->getParameter('licom_domain');
    }

    /**
     * Test competition exists.
     */
    public function testCompetitionExistsTrue()
    {
        $id = 8634;
        $competition = $this->getMock('\Visca\Bundle\LicomBundle\Entity\Competition');
        $competition->expects($this->exactly(2))->method('getId')->will($this->returnValue($id));
        /* @var Competition $competition */
        $this->competitionImageProvider->setCompetition($competition);
        $result = $this->competitionImageProvider->getImageUrl();
        $imagePath = sprintf(
            'http://%s/%s/%s/m/%s.%s',
            $this->domain,
            $this->defaultFolder,
            strtolower(CompetitionImageProvider::ENTITY_NAME),
            $id,
            CompetitionImageProvider::IMAGE_EXTENSION
        );
        $this->assertEquals($imagePath, $result);
        $media = $this->competitionImageProvider->getMedia();
        $this->assertInstanceOf('Visca\Bundle\MediaBundle\Model\Media', $media);
    }

    /**
     * Test competition not exists.
     */
    public function testCompetitionNotExistsTrue()
    {
        $competition = $this->getMock('\Visca\Bundle\LicomBundle\Entity\Competition');
        $competition->expects($this->exactly(2))->method('getId')->will($this->returnValue(0));
        /* @var Competition $competition */
        $this->competitionImageProvider->setCompetition($competition);
        $result = $this->competitionImageProvider->getImageUrl();
        $imagePath = sprintf(
            'http://%s/%s/%s/m/%s.%s',
            $this->domain,
            $this->defaultFolder,
            strtolower(CompetitionImageProvider::ENTITY_NAME),
            CompetitionImageProvider::DEFAULT_IMAGE_NAME,
            CompetitionImageProvider::IMAGE_EXTENSION
        );
        $this->assertEquals($imagePath, $result);

        $media = $this->competitionImageProvider->getMedia();
        $this->assertInstanceOf('Visca\Bundle\MediaBundle\Model\Media', $media);
    }

    /**
     *  Test size not exists.
     */
    public function testSizeNotExists()
    {
        $competition = $this->getMock('\Visca\Bundle\LicomBundle\Entity\Competition');
        $competition->expects($this->exactly(2))->method('getId')->will($this->returnValue(0));
        /* @var Competition $competition */
        $this->competitionImageProvider->setCompetition($competition);
        $this->competitionImageProvider->setSize('not exists');
        $result = $this->competitionImageProvider->getImageUrl();
        $this->assertFalse($result);

        $media = $this->competitionImageProvider->getMedia();
        $this->assertFalse($media);
    }
}
