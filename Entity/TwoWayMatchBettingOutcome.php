<?php

namespace Visca\Bundle\LicomBundle\Entity;

class TwoWayMatchBettingOutcome extends MatchBettingOutcome
{
    /** @var Participant */
    private $winner;

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
