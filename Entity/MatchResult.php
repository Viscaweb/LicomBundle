<?php

namespace Visca\Bundle\LicomBundle\Entity;

use Visca\Bundle\CoreBundle\Entity\Traits\OptionalDateTimeTrait;
use Visca\Bundle\CoreBundle\Entity\Traits\DeletableTrait;
use Visca\Bundle\LicomBundle\Factory\MatchResultFactory;

/**
 * MatchResult.
 *
 * This model describe the Result related to a given Match.
 *
 * Quantity of data: The number of Match is already large, and most of the time a
 * Match is accompanied we have many results.
 *
 * This model usually contains a LARGE amount of rows.
 */
class MatchResult
{
    use OptionalDateTimeTrait;
    use DeletableTrait;

    /**
     * @var int
     */
    private $id;

    /**
     * @var string|null
     */
    private $value;

    /**
     * @var MatchParticipant
     */
    private $matchParticipant;

    /**
     * @var MatchResultType
     */
    private $matchResultType;

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
     * @return MatchResult
     */
    public function setValue($value)
    {
        $this->value = $value;

        return $this;
    }

    /**
     * Get matchParticipant.
     *
     * @return MatchParticipant
     */
    public function getMatchParticipant()
    {
        return $this->matchParticipant;
    }

    /**
     * Set matchParticipant.
     *
     * @param MatchParticipant $matchParticipant
     *
     * @return MatchResult
     */
    public function setMatchParticipant(MatchParticipant $matchParticipant)
    {
        $this->matchParticipant = $matchParticipant;

        return $this;
    }

    /**
     * Get matchResultType.
     *
     * @return MatchResultType
     */
    public function getMatchResultType()
    {
        return $this->matchResultType;
    }

    /**
     * Set matchResultType.
     *
     * @param MatchResultType $matchResultType
     *
     * @return MatchResult
     */
    public function setMatchResultType(MatchResultType $matchResultType)
    {
        $this->matchResultType = $matchResultType;

        return $this;
    }

    /**
     * @return MatchResult
     */
    public static function create()
    {
        $factory = new MatchResultFactory();

        return $factory->create();
    }
}
