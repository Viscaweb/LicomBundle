<?php

namespace Visca\Bundle\LicomBundle\Entity;

/**
 * MatchBettingOutcome.
 */
abstract class MatchBettingOutcome extends BettingOutcome
{
    /**
     * @var Match
     */
    protected $match;

    /**
     * @return Match
     */
    public function getMatch()
    {
        return $this->match;
    }

    /**
     * @param Match $match
     *
     * @return $this
     */
    public function setMatch(Match $match)
    {
        $this->match = $match;

        return $this;
    }
}
