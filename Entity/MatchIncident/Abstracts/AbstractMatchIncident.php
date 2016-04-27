<?php

namespace Visca\Bundle\LicomBundle\Entity\MatchIncident\Abstracts;

use Visca\Bundle\LicomBundle\Entity\MatchIncident\Interfaces\MatchIncidentAuthorInterface;
use Visca\Bundle\LicomBundle\Entity\MatchIncident\Interfaces\MatchIncidentViewInterface;
use Visca\Bundle\LicomBundle\Entity\MatchIncident\MatchIncidentPeriod;

/**
 * Class AbstractMatchIncident.
 */
abstract class AbstractMatchIncident implements MatchIncidentViewInterface
{
    /**
     * @var MatchIncidentAuthorInterface
     */
    protected $author;

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
     * @var MatchIncidentPeriod
     */
    protected $period;

    /**
     * @var string
     */
    protected $referenceCode;

    /**
     * @var int
     */
    protected $matchIncidentTypeCode;

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
     * @return $this
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
     * @return $this
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
     * @return $this
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
     * @return $this
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
     * @return $this
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
     * @return $this
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
     * @return $this
     */
    public function setOrdinalPeriod($ordinalPeriod)
    {
        $this->ordinalPeriod = $ordinalPeriod;

        return $this;
    }

    /**
     * @return MatchIncidentPeriod
     */
    public function getPeriod()
    {
        return $this->period;
    }

    /**
     * @param MatchIncidentPeriod|null $period
     *
     * @return $this
     */
    public function setPeriod($period)
    {
        $this->period = $period;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function setAuthor(MatchIncidentAuthorInterface $author)
    {
        $this->author = $author;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getAuthor()
    {
        return $this->author;
    }

    /**
     * {@inheritdoc}
     */
    public function getReferenceCode()
    {
        return $this->referenceCode;
    }

    /**
     * {@inheritdoc}
     */
    public function setReferenceCode($referenceCode)
    {
        $this->referenceCode = $referenceCode;

        return $this;
    }

    /**
     * @return int
     */
    public function getMatchIncidentTypeCode()
    {
        return $this->matchIncidentTypeCode;
    }

    /**
     * @param int $matchIncidentType
     *
     * @return $this
     */
    public function setMatchIncidentTypeCode($matchIncidentType)
    {
        $this->matchIncidentTypeCode = $matchIncidentType;

        return $this;
    }
}
