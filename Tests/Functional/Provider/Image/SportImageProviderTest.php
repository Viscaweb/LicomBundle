<?php

namespace Visca\Bundle\LicomViewBundle\Tests\Functional\Provider\Image;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Visca\Bundle\LicomBundle\Entity\Sport;
use Visca\Bundle\LicomViewBundle\Provider\Image\SportImageProvider;

/**
 * SportImageProviderTest.
 */
class SportImageProviderTest extends WebTestCase
{
    /**
     * @var SportImageProvider
     */
    public $sportImageProvider;

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
        $this->sportImageProvider = $kernel->getContainer()->get('visca_licom.provider.image.sport');
        $this->defaultFolder = $kernel->getContainer()->getParameter('visca.media.adapter.filesystem.default_folder');
        $this->domain = $kernel->getContainer()->getParameter('licom_domain');
    }

    /**
     * Test sport exists.
     */
    public function testSportExistsTrue()
    {
        $id = 2;
        $sport = $this->getMock('\Visca\Bundle\LicomBundle\Entity\Sport');
        $sport->expects($this->exactly(2))->method('getId')->will($this->returnValue($id));
        /* @var Sport $sport */
        $this->sportImageProvider->setSport($sport);
        $result = $this->sportImageProvider->getImageUrl();
        $imagePath = sprintf(
            'http://%s/%s/%s/m/%s.%s',
            $this->domain,
            $this->defaultFolder,
            strtolower(SportImageProvider::ENTITY_NAME),
            $id,
            SportImageProvider::IMAGE_EXTENSION
        );
        $this->assertEquals($imagePath, $result);
        $media = $this->sportImageProvider->getMedia();
        $this->assertInstanceOf('Visca\Bundle\MediaBundle\Model\Media', $media);
    }

    /**
     * Test sport not exists.
     */
    public function testSportNotExistsTrue()
    {
        $sport = $this->getMock('\Visca\Bundle\LicomBundle\Entity\Sport');
        $sport->expects($this->exactly(2))->method('getId')->will($this->returnValue(0));
        /* @var Sport $sport */
        $this->sportImageProvider->setSport($sport);
        $result = $this->sportImageProvider->getImageUrl();
        $imagePath = sprintf(
            'http://%s/%s/%s/m/%s.%s',
            $this->domain,
            $this->defaultFolder,
            strtolower(SportImageProvider::ENTITY_NAME),
            SportImageProvider::DEFAULT_IMAGE_NAME,
            SportImageProvider::IMAGE_EXTENSION
        );

        $this->assertEquals($imagePath, $result);

        $media = $this->sportImageProvider->getMedia();
        $this->assertInstanceOf('Visca\Bundle\MediaBundle\Model\Media', $media);
    }

    /**
     *  Test size not exists.
     */
    public function testSizeNotExists()
    {
        $sport = $this->getMock('\Visca\Bundle\LicomBundle\Entity\Sport');
        $sport->expects($this->exactly(2))->method('getId')->will($this->returnValue(0));
        /* @var Sport $sport */
        $this->sportImageProvider->setSport($sport);
        $this->sportImageProvider->setSize('not exists');
        $result = $this->sportImageProvider->getImageUrl();
        $this->assertFalse($result);

        $media = $this->sportImageProvider->getMedia();
        $this->assertFalse($media);
    }
}
