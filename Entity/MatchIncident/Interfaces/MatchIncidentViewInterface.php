<?php

namespace Visca\Bundle\LicomBundle\Entity\MatchIncident\Interfaces;

use Visca\Bundle\LicomBundle\Entity\MatchIncident\MatchIncidentPeriod;

/**
 * Interface MatchIncidentViewInterface
 */
interface MatchIncidentViewInterface
{
    /**
     * @return int
     */
    public function getMatchIncidentTypeCode();

    /**
     * @param int $matchIncidentType
     *
     * @return $this
     */
    public function setMatchIncidentTypeCode($matchIncidentType);

    /**
     * @return int
     */
    public function getTimeElapsed();

    /**
     * @param int $timeElapsed
     *
     * @return $this
     */
    public function setTimeElapsed($timeElapsed);

    /**
     * @return int
     */
    public function getTimeElapsedExtra();

    /**
     * @param int $timeElapsedExtra
     *
     * @return $this
     */
    public function setTimeElapsedExtra($timeElapsedExtra);

    /**
     * @return int
     */
    public function getPosition();

    /**
     * @param int $position
     *
     * @return $this
     */
    public function setPosition($position);

    /**
     * @return \DateTime
     */
    public function getTime();

    /**
     * @param \DateTime $time
     *
     * @return $this
     */
    public function setTime($time);

    /**
     * @return string
     */
    public function getIconHTML();

    /**
     * @param string $iconHTML
     *
     * @return $this
     */
    public function setIconHTML($iconHTML);

    /**
     * @return bool|null
     */
    public function getIsHome();

    /**
     * @param bool|null $isHome
     *
     * @return $this
     */
    public function setIsHome($isHome);

    /**
     * @return int
     */
    public function getOrdinalPeriod();

    /**
     * @param int $ordinalPeriod
     *
     * @return $this
     */
    public function setOrdinalPeriod($ordinalPeriod);

    /**
     * @return MatchIncidentPeriod
     */
    public function getPeriod();

    /**
     * @param MatchIncidentPeriod $period
     *
     * @return $this
     */
    public function setPeriod(MatchIncidentPeriod $period);

    /**
     * @param MatchIncidentAuthorInterface $matchIncidentAuthor
     *
     * @return $this
     */
    public function setAuthor(MatchIncidentAuthorInterface $matchIncidentAuthor);

    /**
     * @return MatchIncidentAuthorInterface
     */
    public function getAuthor();

    /**
     * @return string
     */
    public function getReferenceCode();

    /**
     * @param string $referenceCode
     *
     * @return $this
     */
    public function setReferenceCode($referenceCode);
}