<?php

namespace Visca\Bundle\LicomBundle\Entity;

use Visca\Bundle\CoreBundle\Entity\Traits\OptionalDateTimeTrait;
use Visca\Bundle\CoreBundle\Entity\Traits\DeletableTrait;
use Visca\Bundle\LicomBundle\Entity\Traits\OptionalPeriodTrait;

/**
 * MatchTiming.
 *
 * The goal of this model is to relate blocks of time, pre-calculated,
 * about the different event happened during this match.
 */
class MatchTiming
{
    use OptionalDateTimeTrait;
    use DeletableTrait;
    use OptionalPeriodTrait;

    /**
     * @var int
     */
    private $id;

    /**
     * @var Match
     */
    private $match;

    /**
     * @var MatchStatusDescription
     */
    private $matchStatusDescription;

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
     * Get Match.
     *
     * @return Match
     */
    public function getMatch()
    {
        return $this->match;
    }

    /**
     * Set Match.
     *
     * @param Match $match
     *
     * @return MatchTiming
     */
    public function setMatch(Match $match)
    {
        $this->match = $match;

        return $this;
    }

    /**
     * Get MatchStatusDescription.
     *
     * @return MatchStatusDescription
     */
    public function getMatchStatusDescription()
    {
        return $this->matchStatusDescription;
    }

    /**
     * Set MatchStatusDescription.
     *
     * @param MatchStatusDescription $matchStatusDescription
     *
     * @return MatchTiming
     */
    public function setMatchStatusDescription(
        MatchStatusDescription $matchStatusDescription
    ) {
        $this->matchStatusDescription = $matchStatusDescription;

        return $this;
    }
}
