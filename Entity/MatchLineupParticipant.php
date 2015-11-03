<?php

namespace Visca\Bundle\LicomBundle\Entity;

use Visca\Bundle\CoreBundle\Entity\Traits\OptionalDateTimeTrait;
use Visca\Bundle\CoreBundle\Entity\Traits\DeletableTrait;

/**
 * MatchLineupParticipant.
 */
class MatchLineupParticipant
{
    use OptionalDateTimeTrait;
    use DeletableTrait;

    /**
     * @var int
     */
    private $id;

    /**
     * @var Participant
     */
    private $participant;

    /**
     * @var MatchLineup
     */
    private $matchLineup;

    /**
     * @var MatchLineupParticipantType
     */
    private $matchLineupType;

    /**
     * @var int|null
     */
    private $position;

    /**
     * @var int|null
     */
    private $shirt;

    /**
     * Get id.
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Get Participant.
     *
     * @return Participant
     */
    public function getParticipant()
    {
        return $this->participant;
    }

    /**
     * Set Participant.
     *
     * @param Participant $participant
     *
     * @return MatchLineupParticipant
     */
    public function setParticipant(Participant $participant)
    {
        $this->participant = $participant;

        return $this;
    }

    /**
     * Get MatchLineup.
     *
     * @return int
     */
    public function getMatchLineup()
    {
        return $this->matchLineup;
    }

    /**
     * Set MatchLineup.
     *
     * @param MatchLineup $matchLineup
     *
     * @return MatchLineupParticipant
     */
    public function setMatchLineup(MatchLineup $matchLineup)
    {
        $this->matchLineup = $matchLineup;

        return $this;
    }

    /**
     * Get MatchLineupParticipantType.
     *
     * @return MatchLineupParticipantType
     */
    public function getMatchLineupType()
    {
        return $this->matchLineupType;
    }

    /**
     * Set MatchLineupParticipantType.
     *
     * @param MatchLineupParticipantType $matchLineupType
     *
     * @return MatchLineupParticipant
     */
    public function setMatchLineupType(MatchLineupParticipantType $matchLineupType)
    {
        $this->matchLineupType = $matchLineupType;

        return $this;
    }

    /**
     * Get position.
     *
     * @return int|null
     */
    public function getPosition()
    {
        return $this->position;
    }

    /**
     * Set position.
     *
     * @param int|null $position
     *
     * @return MatchLineupParticipant
     */
    public function setPosition($position)
    {
        $this->position = $position;

        return $this;
    }

    /**
     * Get shirt.
     *
     * @return int|null
     */
    public function getShirt()
    {
        return $this->shirt;
    }

    /**
     * Set shirt.
     *
     * @param int|null $shirt
     *
     * @return MatchLineupParticipant
     */
    public function setShirt($shirt)
    {
        $this->shirt = $shirt;

        return $this;
    }
}
