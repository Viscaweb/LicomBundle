<?php

namespace Visca\Bundle\LicomBundle\Entity\MatchIncident;

use Visca\Bundle\SportBundle\Model\MatchIncident\SoccerMatchIncidentPeriod\SoccerMatchIncidentPeriodCode;

/**
 * Class MatchIncidentPeriod.
 */
class MatchIncidentPeriod
{
    /**
     * @var SoccerMatchIncidentPeriodCode
     */
    protected $code;

    /**
     * @var int
     */
    protected $rank;

    /**
     * @var int
     */
    protected $duration;

    /**
     * @var int
     */
    protected $elapsedStartTime;

    /**
     * @var string
     */
    protected $translation;

    /**
     * Get MatchIncidentPeriod code.
     *
     * @return SoccerMatchIncidentPeriodCode
     */
    public function getCode()
    {
        return $this->code;
    }

    /**
     * Set code.
     *
     * @param SoccerMatchIncidentPeriodCode $code SoccerMatchIncidentPeriodCode code.
     *
     * @return MatchIncidentPeriod
     */
    public function setCode(SoccerMatchIncidentPeriodCode $code)
    {
        $this->code = $code;

        return $this;
    }

    /**
     * Get rank.
     *
     * @return int
     */
    public function getRank()
    {
        return $this->rank;
    }

    /**
     * Set rank.
     *
     * @param int $rank Rank.
     *
     * @return MatchIncidentPeriod
     */
    public function setRank($rank)
    {
        $this->rank = $rank;

        return $this;
    }

    /**
     * Get duration of the period, in minutes.
     *
     * @return int
     */
    public function getDuration()
    {
        return $this->duration;
    }

    /**
     * Set duration of the period, in minutes.
     *
     * @param int $duration Duration of the period in minutes.
     *
     * @return MatchIncidentPeriod
     */
    public function setDuration($duration)
    {
        $this->duration = $duration;

        return $this;
    }

    /**
     * Get starting time, in minutes.
     *
     * @return int
     */
    public function getElapsedStartTime()
    {
        return $this->elapsedStartTime;
    }

    /**
     * Set starting time of the period.
     *
     * @param int $elapsedStartTime Starting time of the period, in minutes.
     *
     * @return MatchIncidentPeriod
     */
    public function setElapsedStartTime($elapsedStartTime)
    {
        $this->elapsedStartTime = $elapsedStartTime;

        return $this;
    }

    /**
     * @return string
     */
    public function getTranslation()
    {
        return $this->translation;
    }

    /**
     * @param string $translation
     *
     * @return MatchIncidentPeriod
     */
    public function setTranslation($translation)
    {
        $this->translation = $translation;

        return $this;
    }
}
