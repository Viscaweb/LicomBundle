<?php

namespace Visca\Bundle\LicomBundle\Services;

use Visca\Bundle\LicomBundle\Entity\MatchIncident;

/**
 * Class MatchIncidentPeriodHelper.
 */
class MatchIncidentPeriodHelper
{
    /**
     * get the ordinal number for the period depending the Sport.
     *
     * @param MatchIncident $matchIncident
     *
     * @return int
     */
    public function getOrdinalPeriod(MatchIncident $matchIncident)
    {
        $sport = $matchIncident
            ->getMatchIncidentType()
            ->getSport();

        switch ($sport->getId()) {
            case 1:
                $ordinal = $this->getSoccerOrdinalPeriod($matchIncident);
                break;

            default:
                $ordinal = $this->getDefaultOrdinalPeriod();
                break;

        }

        return $ordinal;
    }

    /**
     * @return int
     */
    protected function getDefaultOrdinalPeriod()
    {
        return 1;
    }

    /**
     * @param MatchIncident $matchIncident
     *
     * @return int
     */
    protected function getSoccerOrdinalPeriod(MatchIncident $matchIncident)
    {
        $timeElapsed = $matchIncident->getTimeElapsed();

        if ($timeElapsed > 120) {
            $ordinal = 5;
        } elseif ($timeElapsed > 105) {
            $ordinal = 4;
        } elseif ($timeElapsed > 90) {
            $ordinal = 3;
        } elseif ($timeElapsed > 45) {
            $ordinal = 2;
        } else {
            $ordinal = 1;
        }

        return $ordinal;
    }
}
