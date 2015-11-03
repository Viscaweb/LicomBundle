<?php

namespace Visca\Bundle\LicomBundle\Entity\MatchIncident\Abstracts;

/**
 * Class AbstractMatchIncident.
 */
abstract class AbstractMatchIncident
{
    /**
     * Relative time in the Match.
     *
     * @var int
     */
    protected $timeElapsed;

    /**
     * Extra time relative to the timeElapsed.
     *
     * @var int
     */
    protected $timeElapsedExtra;

    /**
     * Sorter helper when two incidents has the same ElapsedTime+Extra.
     *
     * @var int
     */
    protected $position;

    /**
     * UTC DateTime of the Event.
     *
     * @var \DateTime
     */
    protected $time;

    /**
     * HTML code to show the icon.
     *
     * @var string
     */
    protected $iconHTML;

    /**
     * Property to know if the incident is for the Home Participant:
     *  - true is Home
     *  - false is Away
     *  - null  is Undefined.
     *
     * @var bool|null
     */
    protected $isHome;

    /**
     * Ordinal number period.
     *
     * @var int
     */
    protected $ordinalPeriod;

    /**
     * @return int
     */
    public function getTimeElapsed()
    {
        return $this->timeElapsed;
    }

    /**
     * @param int $timeElapsed
     *
     * @return AbstractMatchIncident
     */
    public function setTimeElapsed($timeElapsed)
    {
        $this->timeElapsed = $timeElapsed;

        return $this;
    }

    /**
     * @return int
     */
    public function getTimeElapsedExtra()
    {
        return $this->timeElapsedExtra;
    }

    /**
     * @param int $timeElapsedExtra
     *
     * @return AbstractMatchIncident
     */
    public function setTimeElapsedExtra($timeElapsedExtra)
    {
        $this->timeElapsedExtra = $timeElapsedExtra;

        return $this;
    }

    /**
     * @return int
     */
    public function getPosition()
    {
        return $this->position;
    }

    /**
     * @param int $position
     *
     * @return AbstractMatchIncident
     */
    public function setPosition($position)
    {
        $this->position = $position;

        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getTime()
    {
        return $this->time;
    }

    /**
     * @param \DateTime $time
     *
     * @return AbstractMatchIncident
     */
    public function setTime($time)
    {
        $this->time = $time;

        return $this;
    }

    /**
     * @return string
     */
    public function getIconHTML()
    {
        return $this->iconHTML;
    }

    /**
     * @param string $iconHTML
     *
     * @return AbstractMatchIncident
     */
    public function setIconHTML($iconHTML)
    {
        $this->iconHTML = $iconHTML;

        return $this;
    }

    /**
     * @return bool|null
     */
    public function getIsHome()
    {
        return $this->isHome;
    }

    /**
     * @param bool|null $isHome
     *
     * @return AbstractMatchIncident
     */
    public function setIsHome($isHome)
    {
        $this->isHome = $isHome;

        return $this;
    }

    /**
     * @return int
     */
    public function getOrdinalPeriod()
    {
        return $this->ordinalPeriod;
    }

    /**
     * @param int $ordinalPeriod
     *
     * @return AbstractMatchIncident
     */
    public function setOrdinalPeriod($ordinalPeriod)
    {
        $this->ordinalPeriod = $ordinalPeriod;

        return $this;
    }
}
