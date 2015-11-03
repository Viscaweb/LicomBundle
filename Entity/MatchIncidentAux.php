<?php

namespace Visca\Bundle\LicomBundle\Entity;

use Visca\Bundle\CoreBundle\Entity\Traits\DeletableTrait;
use Visca\Bundle\LicomBundle\Entity\Interfaces\AuxInterface;

/**
 * MatchIncidentAux.
 */
class MatchIncidentAux implements AuxInterface
{
    use DeletableTrait;

    /**
     * @var string
     */
    private $value;

    /**
     * @var MatchIncident
     */
    private $matchIncident;

    /**
     * @var MatchIncidentAuxType
     */
    private $type;

    /**
     * Get MatchIncident.
     *
     * @return MatchIncident
     */
    public function getMatchIncident()
    {
        return $this->matchIncident;
    }

    /**
     * Set MatchIncident.
     *
     * @param MatchIncident $matchIncident
     *
     * @return MatchIncidentAux
     */
    public function setMatchIncident(MatchIncident $matchIncident)
    {
        $this->matchIncident = $matchIncident;

        return $this;
    }

    /**
     * Get MatchIncidentAuxType.
     *
     * @return MatchIncidentAuxType
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Set MatchIncidentAuxType.
     *
     * @param MatchIncidentAuxType $type
     *
     * @return MatchIncidentAux
     */
    public function setType(MatchIncidentAuxType $type)
    {
        $this->type = $type;

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
     * @return MatchIncidentAux
     */
    public function setValue($value)
    {
        $this->value = $value;

        return $this;
    }
}
