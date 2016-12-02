<?php

namespace Visca\Bundle\LicomBundle\Events\Traits;

trait ListenByCompetitionTrait
{
    /**
     * @param int $competitionId
     *
     * @return static
     */
    public static function listenByCompetition($competitionId)
    {
        return new static('competition.'.$competitionId);
    }
}
