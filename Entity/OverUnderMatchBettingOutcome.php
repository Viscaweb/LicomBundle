<?php

namespace Visca\Bundle\LicomBundle\Entity;

/**
 * Class OverUnderMatchBettingOutcome.
 */
class OverUnderMatchBettingOutcome extends MatchBettingOutcome
{
    /**
     * @var null|int
     */
    protected $goalsTotal;

    /**
     * @return null|int
     */
    public function getGoalsTotal()
    {
        return $this->goalsTotal;
    }

    /**
     * @param null|int $goalsTotal
     *
     * @return $this
     */
    public function setGoalsTotal($goalsTotal)
    {
        $this->goalsTotal = $goalsTotal;

        return $this;
    }
}
