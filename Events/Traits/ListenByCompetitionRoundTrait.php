<?php

namespace Visca\Bundle\LicomBundle\Events\Traits;

use Visca\Bundle\LicomBundle\Entity\CompetitionRound;

trait ListenByCompetitionRoundTrait
{
    /**
     * @param LicomCompetitionRound $round
     *
     * @return static
     */
    public static function listenByCompetitionRound(CompetitionRound $round)
    {
        return new static('competition_round.'.$round->getId());
    }
}
