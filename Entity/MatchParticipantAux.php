<?php

namespace Visca\Bundle\LicomBundle\Entity;

use Visca\Bundle\CoreBundle\Entity\Traits\DeletableTrait;

/**
 * MatchParticipantAux.
 */
class MatchParticipantAux
{
    use DeletableTrait;

    /**
     * @var MatchParticipant
     */
    private $matchParticipant;

    /**
     * @var MatchParticipantAuxType
     */
    private $matchParticipantAuxType;

    /**
     * @var string
     */
    private $value;

    /**
     * Get matchParticipant.
     */
    public function getMatchParticipant()
    {
        return $this->matchParticipant;
    }

    /**
     * Set matchParticipant.
     *
     * @param MatchParticipant $matchParticipant
     *
     * @return MatchParticipantAux
     */
    public function setMatchParticipant(MatchParticipant $matchParticipant)
    {
        $this->matchParticipant = $matchParticipant;

        return $this;
    }

    /**
     * Get matchParticipantAuxType.
     *
     * @return MatchParticipantAuxType
     */
    public function getMatchParticipantAuxType()
    {
        return $this->matchParticipantAuxType;
    }

    /**
     * Set matchParticipantAuxType.
     *
     * @param MatchParticipantAuxType $matchParticipantAuxType
     *
     * @return MatchParticipantAux
     */
    public function setMatchParticipantAuxType(
        MatchParticipantAuxType $matchParticipantAuxType
    ) {
        $this->matchParticipantAuxType = $matchParticipantAuxType;

        return $this;
    }

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
     * @return MatchParticipantAux
     */
    public function setValue($value)
    {
        $this->value = $value;

        return $this;
    }
}
