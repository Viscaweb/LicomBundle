<?php

namespace Visca\Bundle\LicomBundle\Entity;

use Visca\Bundle\CoreBundle\Entity\Traits\DeletableTrait;
use Visca\Bundle\LicomBundle\Entity\Interfaces\AuxInterface;

/**
 * MatchParticipantAux.
 */
class MatchParticipantAux implements AuxInterface
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
     * @inheritdoc
     */
    public function getType()
    {
        return $this->matchParticipantAuxType;
    }

    /**
     * Get matchParticipantAuxType.
     *
     * @return MatchParticipantAuxType
     *
     * @deprecated Use getType() instead
     */
    public function getMatchParticipantAuxType()
    {
        return $this->getType();
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
