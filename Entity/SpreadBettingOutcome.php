<?php

namespace Visca\Bundle\LicomBundle\Entity;

class SpreadBettingOutcome extends MatchBettingOutcome
{
    /** @var Participant */
    private $winner;

    /**
     * @var float
     */
    private $handicap;

    /**
     * @return float
     */
    public function getHandicap()
    {
        return $this->handicap;
    }

    /**
     * @param float $handicap
     *
     * @return $this
     */
    public function setHandicap($handicap)
    {
        $this->handicap = $handicap;

        return $this;
    }

    /**
     * @return Participant
     */
    public function getWinner()
    {
        return $this->winner;
    }

    /**
     * @param Participant $winner
     *
     * @return $this
     */
    public function setWinner(Participant $winner)
    {
        $this->winner = $winner;

        return $this;
    }
}
