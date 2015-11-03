<?php

namespace Visca\Bundle\LicomBundle\Entity\MatchIncident;

use Visca\Bundle\LicomBundle\Entity\Participant;
use Visca\Bundle\LicomBundle\Entity\MatchIncident\Abstracts\AbstractMatchIncident;

/**
 * Class Goal.
 */
class Goal extends AbstractMatchIncident
{
    /**
     * Participant, usually athlete or coach.
     *
     * @var Participant
     */
    protected $participant;

    /**
     * @return Participant
     */
    public function getParticipant()
    {
        return $this->participant;
    }

    /**
     * @param Participant $participant
     *
     * @return Goal
     */
    public function setParticipant($participant)
    {
        $this->participant = $participant;

        return $this;
    }
}
