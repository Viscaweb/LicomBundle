<?php

namespace Visca\Bundle\LicomViewBundle\Provider\Image;

use Visca\Bundle\LicomBundle\Entity\Participant;
use Visca\Bundle\LicomViewBundle\Provider\Image\Abstracts\AbstractImageProvider;

/**
 * ParticipantImageProvider.
 */
class ParticipantImageProvider extends AbstractImageProvider
{
    const ENTITY_NAME = 'participant';

    /**
     * @var Participant Participant Entity
     */
    protected $participant;

    /**
     * @param Participant $participant Participant object
     *
     * @return $this
     */
    public function setParticipant(Participant $participant)
    {
        $this->participant = $participant;

        return $this;
    }

    /**
     * @return string
     */
    public function getDescription()
    {
        return $this->participant->getName();
    }

    /**
     * @return string
     */
    public function getImageName()
    {
        return (string) $this->participant->getId();
    }
}
