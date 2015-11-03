<?php

namespace Visca\Bundle\LicomViewBundle\Twig\Entity;

use Visca\Bundle\LicomBundle\Entity\Participant;
use Visca\Bundle\LicomViewBundle\Helper\Entity\ParticipantHelper;
use Visca\Bundle\LicomViewBundle\Provider\Image\ParticipantImageProvider;
use Visca\Bundle\MediaBundle\Twig\Abstracts\AbstractTwigExtension;

/**
 * Class ParticipantExtension.
 */
class ParticipantExtension extends AbstractTwigExtension
{
    /**
     * @var ParticipantHelper
     */
    private $participantHelper;

    /**
     * @var ParticipantImageProvider
     */
    protected $imageProvider;

    /**
     * Constructor.
     *
     * @param ParticipantHelper        $participantHelper        Required service
     * @param ParticipantImageProvider $participantImageProvider ParticipantImageProvider service
     */
    public function __construct(
        ParticipantHelper $participantHelper,
        ParticipantImageProvider $participantImageProvider
    ) {
        parent::__construct($participantImageProvider);
        $this->participantHelper = $participantHelper;
    }

    /**
     * {@inheritdoc}
     */
    public function getFunctions()
    {
        return [
            new \Twig_SimpleFunction(
                'participant_name',
                [$this, 'getParticipantName']
            ),
            new \Twig_SimpleFunction(
                'participant_icon_small',
                [$this, 'getParticipantIconSmall'],
                ['is_safe' => ['html']]
            ),
            new \Twig_SimpleFunction(
                'participant_icon_medium',
                [$this, 'getParticipantIconMedium'],
                ['is_safe' => ['html']]
            ),
            new \Twig_SimpleFunction(
                'participant_icon_source_small',
                [$this, 'getParticipantIconSourceSmall']
            ),
            new \Twig_SimpleFunction(
                'participant_icon_source_medium',
                [$this, 'getParticipantIconSourceMedium']
            ),
        ];
    }

    /**
     * @param Participant $participant Participant object
     * @param int         $maxLength   MaxLength
     *
     * @return string
     */
    public function getParticipantName(
        Participant $participant,
        $maxLength = 10
    ) {
        return $this->participantHelper->getName(
            $participant,
            $maxLength
        );
    }

    /**
     * @param Participant $participant Participant object
     *
     * @return string
     */
    public function getParticipantIconMedium(Participant $participant)
    {
        return $this->getParticipantIcon($participant, 'm');
    }

    /**
     * @param Participant $participant Participant object
     *
     * @return string
     */
    public function getParticipantIconSourceMedium(Participant $participant)
    {
        return $this->getParticipantIconSource($participant, 'm');
    }

    /**
     * @param Participant $participant Participant object
     *
     * @return string
     */
    public function getParticipantIconSmall(Participant $participant)
    {
        return $this->getParticipantIcon($participant, 's');
    }

    /**
     * @param Participant $participant Participant object
     *
     * @return string
     */
    public function getParticipantIconSourceSmall(Participant $participant)
    {
        return $this->getParticipantIconSource($participant, 's');
    }

    /**
     * @param Participant $participant Participant object
     * @param string      $size        Size
     *
     * @return string
     */
    private function getParticipantIcon(
        Participant $participant,
        $size
    ) {
        $this->imageProvider
            ->setParticipant($participant)
            ->setSize($size);
        $media = $this->imageProvider->getMedia();

        return $this->getIcon($media);
    }

    /**
     * @param Participant $participant Participant object
     * @param string      $size        Size ('medium'|'s')
     *
     * @return string
     */
    private function getParticipantIconSource(
        Participant $participant,
        $size
    ) {
        $this->imageProvider
            ->setParticipant($participant)
            ->setSize($size);
        $media = $this->imageProvider->getMedia();

        return $this->getSource($media);
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'visca_licom_extension_entity_participant';
    }
}
