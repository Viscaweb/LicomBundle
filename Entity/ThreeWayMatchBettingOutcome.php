<?php

namespace Visca\Bundle\LicomBundle\Entity;

/**
 * Class ThreeWayMatchBettingOutcome.
 */
class ThreeWayMatchBettingOutcome extends MatchBettingOutcome
{
    /**
     * @var Participant|null
     */
    protected $winner;

    /**
     * @return null|Participant
     */
    public function getWinner()
    {
        return $this->winner;
    }

    /**
     * @param null|Participant $winner
     *
     * @return $this
     */
    public function setWinner(Participant $winner = null)
    {
        $this->winner = $winner;

        return $this;
    }
}
