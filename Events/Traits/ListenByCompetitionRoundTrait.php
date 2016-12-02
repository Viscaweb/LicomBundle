<?php

namespace Visca\Bundle\LicomBundle\Events\Traits;

trait ListenByCompetitionRoundTrait
{
    /**
     * @param int $roundId
     *
     * @return static
     */
    public static function listenByCompetitionRound($roundId)
    {
        return new static('competition_round.'.$roundId);
    }
}
