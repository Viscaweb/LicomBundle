<?php

namespace Visca\Bundle\LicomBundle\Entity\MatchIncident;

use Visca\Bundle\LicomBundle\Entity\MatchIncident\Interfaces\MatchIncidentAuthorInterface;
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
     * @var MatchIncidentAuthorInterface
     */
    protected $assistant;

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

    /**
     * @return MatchIncidentAuthorInterface
     */
    public function getAssistant()
    {
        return $this->assistant;
    }

    /**
     * @param MatchIncidentAuthorInterface $assistant
     *
     * @return Goal
     */
    public function setAssistant($assistant)
    {
        $this->assistant = $assistant;

        return $this;
    }
}
