<?php

namespace Visca\Bundle\LicomBundle\Entity\MatchIncident;

use Visca\Bundle\LicomBundle\Entity\Participant;
use Visca\Bundle\LicomBundle\Entity\MatchIncident\Abstracts\AbstractMatchIncident;

/**
 * Class PlayerChange.
 */
class PlayerChange extends AbstractMatchIncident
{
    /**
     * Participant In.
     *
     * @var Participant
     */
    protected $participantIn;

    /**
     * Participant Out.
     *
     * @var Participant
     */
    protected $participantOut;

    /**
     * @return Participant
     */
    public function getParticipantIn()
    {
        return $this->participantIn;
    }

    /**
     * @param Participant $participantIn
     *
     * @return PlayerChange
     */
    public function setParticipantIn($participantIn)
    {
        $this->participantIn = $participantIn;

        return $this;
    }

    /**
     * @return Participant
     */
    public function getParticipantOut()
    {
        return $this->participantOut;
    }

    /**
     * @param Participant $participantOut
     *
     * @return PlayerChange
     */
    public function setParticipantOut($participantOut)
    {
        $this->participantOut = $participantOut;

        return $this;
    }
}
