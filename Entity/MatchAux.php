<?php

namespace Visca\Bundle\LicomBundle\Entity;

use Visca\Bundle\CoreBundle\Entity\Traits\OptionalDateTimeTrait;
use Visca\Bundle\CoreBundle\Entity\Traits\DeletableTrait;
use Visca\Bundle\LicomBundle\Entity\Interfaces\AuxInterface;

/**
 * MatchAux.
 *
 * This model contains all additional information related to the match.
 *
 * Quantity of data: The number of Match is already large, so the number of auxiliaries is even bigger.
 * This model usually contains a LARGE amount of rows.
 *
 * What’s the difference between MatchAux and MatchAuxProfile ?
 * Please look inside the MatchAuxProfile object to get more information.
 *
 * @example Referee Name
 * @example Stadium Name
 * @example Spectators
 */
class MatchAux implements AuxInterface
{
    use OptionalDateTimeTrait;
    use DeletableTrait;

    /**
     * @var string
     */
    private $value;

    /**
     * @var Match
     */
    private $match;

    /**
     * @var MatchAuxType
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
     * @return MatchAux
     */
    public function setValue($value)
    {
        $this->value = $value;

        return $this;
    }

    /**
     * Get match.
     *
     * @return Match
     */
    public function getMatch()
    {
        return $this->match;
    }

    /**
     * Set match.
     *
     * @param Match $match
     *
     * @return MatchAux
     */
    public function setMatch(Match $match)
    {
        $this->match = $match;

        return $this;
    }

    /**
     * Get matchAuxType.
     *
     * @return MatchAuxType
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Set matchAuxType.
     *
     * @param MatchAuxType $type
     *
     * @return MatchAux
     */
    public function setType(MatchAuxType $type)
    {
        $this->type = $type;

        return $this;
    }
}
