<?php

namespace Visca\Bundle\LicomBundle\Entity\MatchIncident;

use Visca\Bundle\LicomBundle\Entity\Participant;
use Visca\Bundle\LicomBundle\Entity\MatchIncident\Abstracts\AbstractMatchIncident;

/**
 * Class Card.
 */
class Card extends AbstractMatchIncident
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
     * @return Card
     */
    public function setParticipant($participant)
    {
        $this->participant = $participant;

        return $this;
    }
}
