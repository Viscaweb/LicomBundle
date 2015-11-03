<?php

namespace Visca\Bundle\LicomBundle\Entity\MatchPeriod\Abstracts;

use Visca\Bundle\LicomBundle\Entity\MatchIncident\Abstracts\AbstractMatchIncident;
use Visca\Bundle\LicomBundle\Services\MatchIncidentPeriodHelper;

/**
 * Class AbstractMatchPeriod.
 */
abstract class AbstractMatchPeriod
{
    /**
     * Set of MatchIncident that happened in the period.
     *
     * @var AbstractMatchIncident[]
     */
    protected $matchIncidents = [];

    /**
     * @var string
     */
    protected $title;

    /**
     * @var int
     */
    protected $ordinalPosition;

    /**
     * @var MatchIncidentPeriodHelper
     */
    protected $matchIncidentPeriodHelper;

    /**
     * @return AbstractMatchIncident[]
     */
    public function getMatchIncidents()
    {
        return $this->matchIncidents;
    }

    /**
     * @param AbstractMatchIncident[] $matchIncidents
     *
     * @return AbstractMatchPeriod
     */
    public function setMatchIncidents($matchIncidents)
    {
        $this->matchIncidents = $matchIncidents;

        return $this;
    }

    /**
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param string $title
     *
     * @return AbstractMatchPeriod
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * @return int
     */
    public function getOrdinalPosition()
    {
        return $this->ordinalPosition;
    }

    /**
     * @param int $ordinalPosition
     *
     * @return AbstractMatchPeriod
     */
    public function setOrdinalPosition($ordinalPosition)
    {
        $this->ordinalPosition = $ordinalPosition;

        return $this;
    }

    /**
     * @param AbstractMatchIncident $matchIncident
     *
     * @return AbstractMatchPeriod
     */
    public function pushMatchIncident(AbstractMatchIncident $matchIncident)
    {
        $this->matchIncidents[] = $matchIncident;

        return $this;
    }
}
