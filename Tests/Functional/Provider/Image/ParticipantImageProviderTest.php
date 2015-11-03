<?php

namespace Visca\Bundle\LicomViewBundle\Tests\Functional\Provider\Image;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Visca\Bundle\LicomBundle\Entity\Participant;
use Visca\Bundle\LicomViewBundle\Provider\Image\ParticipantImageProvider;

/**
 * ParticipantImageProviderTest.
 */
class ParticipantImageProviderTest extends WebTestCase
{
    /**
     * @var ParticipantImageProvider
     */
    public $participantImageProvider;

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
        $this->participantImageProvider = $kernel->getContainer()->get('visca_licom.provider.image.participant');
        $this->defaultFolder = $kernel->getContainer()->getParameter('visca.media.adapter.filesystem.default_folder');
        $this->domain = $kernel->getContainer()->getParameter('licom_domain');
    }

    /**
     * Test participant exists.
     */
    public function testParticipantExistsTrue()
    {
        $id = 8634;
        $participant = $this->getMock('\Visca\Bundle\LicomBundle\Entity\Participant');
        $participant->expects($this->exactly(2))->method('getId')->will($this->returnValue($id));
        /* @var Participant $participant */
        $this->participantImageProvider->setParticipant($participant);
        $result = $this->participantImageProvider->getImageUrl();
        $imagePath = sprintf(
            'http://%s/%s/%s/m/%s.%s',
            $this->domain,
            $this->defaultFolder,
            strtolower(ParticipantImageProvider::ENTITY_NAME),
            $id,
            ParticipantImageProvider::IMAGE_EXTENSION
        );
        $this->assertEquals($imagePath, $result);
        $media = $this->participantImageProvider->getMedia();
        $this->assertInstanceOf('Visca\Bundle\MediaBundle\Model\Media', $media);
    }

    /**
     * Test participant not exists.
     */
    public function testParticipantNotExistsTrue()
    {
        $participant = $this->getMock('\Visca\Bundle\LicomBundle\Entity\Participant');
        $participant->expects($this->exactly(2))->method('getId')->will($this->returnValue(0));
        /* @var Participant $participant */
        $this->participantImageProvider->setParticipant($participant);
        $result = $this->participantImageProvider->getImageUrl();
        $imagePath = sprintf(
            'http://%s/%s/%s/m/%s.%s',
            $this->domain,
            $this->defaultFolder,
            strtolower(ParticipantImageProvider::ENTITY_NAME),
            ParticipantImageProvider::DEFAULT_IMAGE_NAME,
            ParticipantImageProvider::IMAGE_EXTENSION
        );
        $this->assertEquals($imagePath, $result);

        $media = $this->participantImageProvider->getMedia();
        $this->assertInstanceOf('Visca\Bundle\MediaBundle\Model\Media', $media);
    }

    /**
     *  Test size not exists.
     */
    public function testSizeNotExists()
    {
        $participant = $this->getMock('\Visca\Bundle\LicomBundle\Entity\Participant');
        $participant->expects($this->exactly(2))->method('getId')->will($this->returnValue(0));
        /* @var Participant $participant */
        $this->participantImageProvider->setParticipant($participant);
        $this->participantImageProvider->setSize('not exists');
        $result = $this->participantImageProvider->getImageUrl();
        $this->assertFalse($result);

        $media = $this->participantImageProvider->getMedia();
        $this->assertFalse($media);
    }
}
