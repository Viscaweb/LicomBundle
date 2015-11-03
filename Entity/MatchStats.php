<?php

namespace Visca\Bundle\LicomBundle\Entity;

use Visca\Bundle\CoreBundle\Entity\Traits\OptionalDateTimeTrait;
use Visca\Bundle\CoreBundle\Entity\Traits\DeletableTrait;

/**
 * MatchStats.
 *
 * This model describe the Statistics related to a given Match.
 */
class MatchStats
{
    use OptionalDateTimeTrait;
    use DeletableTrait;

    /**
     * @var int
     */
    private $id;

    /**
     * @var MatchParticipant
     */
    private $matchParticipant;

    /**
     * @var MatchStatsType
     */
    private $matchStatsType;

    /**
     * @var string|null
     */
    private $value;

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
     * Get MatchParticipant.
     *
     * @return MatchParticipant
     */
    public function getMatchParticipant()
    {
        return $this->matchParticipant;
    }

    /**
     * Set MatchParticipant.
     *
     * @param MatchParticipant $matchParticipant
     *
     * @return MatchStats
     */
    public function setMatchParticipant(MatchParticipant $matchParticipant)
    {
        $this->matchParticipant = $matchParticipant;

        return $this;
    }

    /**
     * Get MatchStatsType.
     *
     * @return MatchStatsType
     */
    public function getMatchStatsType()
    {
        return $this->matchStatsType;
    }

    /**
     * Set MatchStatsType.
     *
     * @param MatchStatsType $matchStatsType
     *
     * @return MatchStats
     */
    public function setMatchStatsType(MatchStatsType $matchStatsType)
    {
        $this->matchStatsType = $matchStatsType;

        return $this;
    }

    /**
     * Get value.
     *
     * @return string|null
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * Set value.
     *
     * @param string|null $value
     *
     * @return MatchStats
     */
    public function setValue($value)
    {
        $this->value = $value;

        return $this;
    }
}
