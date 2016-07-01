<?php

namespace Visca\Bundle\LicomBundle\Entity;

use Visca\Bundle\CoreBundle\Entity\Traits\DeletableTrait;
use Visca\Bundle\CoreBundle\Entity\Traits\OptionalDateTimeTrait;

/**
 * MatchIncidentType.
 */
class MatchIncidentType
{
    use OptionalDateTimeTrait;
    use DeletableTrait;

    const CODE_ASSIST = 'Assist';
    const CODE_MISSED_PENALTY = 'MissedPenalty';
    const CODE_OWN_GOAL = 'OwnGoal';
    const CODE_PENALTY = 'Penalty';
    const CODE_PENALTY_SHOOTOUT_MISSED = 'PenaltyShootoutMissed';
    const CODE_PENALTY_SHOOTOUT_SCORED = 'PenaltyShootoutScored';
    const CODE_REGULAR_GOAL = 'RegularGoal';
    const CODE_RED_CARD = 'RedCard';
    const CODE_SUBSTITUTION_IN = 'SubstitutionIn';
    const CODE_SUBSTITUTION_OUT = 'SubstitutionOut';
    const CODE_YELLOW_CARD = 'YellowCard';
    const CODE_YELLOW_CARD2 = 'YellowCard2';

    /**
     * @var int
     */
    private $id;

    /**
     * @var string
     */
    private $code;

    /**
     * @var string
     */
    private $name;

    /**
     * @var string
     */
    private $category;

    /**
     * @var Sport
     */
    private $sport;

    /**
     * @var MatchIncident
     */
    private $matchIncident;

    /**
     * Get id.
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set id.
     *
     * @param int $id
     *
     * @return MatchIncidentType
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Get name.
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set name.
     *
     * @param string $name
     *
     * @return MatchIncidentType
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get category.
     *
     * @return string
     */
    public function getCategory()
    {
        return $this->category;
    }

    /**
     * Set category.
     *
     * @param string $category
     *
     * @return MatchIncidentType
     */
    public function setCategory($category)
    {
        $this->category = $category;

        return $this;
    }

    /**
     * Get Sport.
     *
     * @return Sport
     */
    public function getSport()
    {
        return $this->sport;
    }

    /**
     * Set Sport.
     *
     * @param Sport $sport
     *
     * @return MatchIncidentType
     */
    public function setSport(Sport $sport = null)
    {
        $this->sport = $sport;

        return $this;
    }

    /**
     * Get matchIncident.
     *
     * @return MatchIncident
     */
    public function getMatchIncident()
    {
        return $this->matchIncident;
    }

    /**
     * Set matchIncident.
     *
     * @param MatchIncident $matchIncident
     *
     * @return MatchIncidentType
     */
    public function setMatchIncident(
        MatchIncident $matchIncident = null
    ) {
        $this->matchIncident = $matchIncident;

        return $this;
    }

    /**
     * Get code.
     *
     * @return string
     */
    public function getCode()
    {
        return $this->code;
    }

    /**
     * Set code.
     *
     * @param string $code
     *
     * @return MatchIncidentType
     */
    public function setCode($code)
    {
        $this->code = $code;

        return $this;
    }

    /**
     * Method to know if this incident type is a red card.
     */
    public function isRedCard()
    {
        return (in_array($this->getCode(), [self::CODE_RED_CARD, self::CODE_YELLOW_CARD2]));
    }

    /**
     * @return bool
     */
    public function isAssist()
    {
        return $this->getCode() === self::CODE_ASSIST;
    }

    /**
     * @return bool
     */
    public function isMissedPenalty()
    {
        return $this->getCode() === self::CODE_MISSED_PENALTY;
    }

    /**
     * @return bool
     */
    public function isOwnGoal()
    {
        return $this->getCode() === self::CODE_OWN_GOAL;
    }

    /**
     * @return bool
     */
    public function isPenalty()
    {
        return $this->getCode() === self::CODE_PENALTY;
    }

    /**
     * @return bool
     */
    public function isPenaltyShootoutMissed()
    {
        return $this->getCode() === self::CODE_PENALTY_SHOOTOUT_MISSED;
    }

    /**
     * @return bool
     */
    public function isPenaltyShootoutScored()
    {
        return $this->getCode() === self::CODE_PENALTY_SHOOTOUT_SCORED;
    }

    /**
     * @return bool
     */
    public function isRegularGoal()
    {
        return $this->getCode() === self::CODE_REGULAR_GOAL;
    }

    /**
     * @return bool
     */
    public function isSubstitionIn()
    {
        return $this->getCode() === self::SUBSTITUTION_IN;
    }

    /**
     * @return bool
     */
    public function isSubstitionOut()
    {
        return $this->getCode() === self::CODE_SUBSTITUTION_OUT;
    }

    /**
     * @return bool
     */
    public function isYellowCard()
    {
        return $this->getCode() === self::CODE_YELLOW_CARD;
    }
}
