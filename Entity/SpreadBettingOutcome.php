<?php

namespace Visca\Bundle\LicomBundle\Entity;

class SpreadBettingOutcome extends MatchBettingOutcome
{
    /** @var Participant */
    private $winner;

    /**
     * @var null|float
     */
    private $handicap;

    /**
     * @return float|null
     */
    public function getHandicap()
    {
        return $this->handicap;
    }

    /**
     * @param int|float $handicap
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
