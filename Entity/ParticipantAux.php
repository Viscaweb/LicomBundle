<?php

namespace Visca\Bundle\LicomBundle\Entity;

use Visca\Bundle\CoreBundle\Entity\Traits\DeletableTrait;
use Visca\Bundle\LicomBundle\Entity\Interfaces\AuxInterface;

/**
 * ParticipantAux.
 */
class ParticipantAux implements AuxInterface
{
    const YES = 'yes';
    const NO = 'no';

    use DeletableTrait;

    /**
     * @var string
     */
    private $value;

    /**
     * @var Participant
     */
    private $participant;

    /**
     * @var ParticipantAuxType
     */
    private $type;

    /**
     * Get value.
     *
     * @return string
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * Set value.
     *
     * @param string $value
     *
     * @return ParticipantAux
     */
    public function setValue($value)
    {
        $this->value = $value;

        return $this;
    }

    /**
     * Get participant.
     *
     * @return Participant
     */
    public function getParticipant()
    {
        return $this->participant;
    }

    /**
     * Set participant.
     *
     * @param Participant $participant
     *
     * @return ParticipantAux
     */
    public function setParticipant(
        Participant $participant
    ) {
        $this->participant = $participant;

        return $this;
    }

    /**
     * Get participantAuxType.
     *
     * @return ParticipantAuxType
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Set participantAuxType.
     *
     * @param ParticipantAuxType $type
     *
     * @return ParticipantAux
     */
    public function setType(
        ParticipantAuxType $type
    ) {
        $this->type = $type;

        return $this;
    }
}
