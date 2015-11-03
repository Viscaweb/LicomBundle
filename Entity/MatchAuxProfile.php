<?php

namespace Visca\Bundle\LicomBundle\Entity;

use Visca\Bundle\CoreBundle\Entity\Traits\DeletableTrait;
use Visca\Bundle\LicomBundle\Factory\MatchAuxProfileFactory;

/**
 * MatchAuxProfile.
 *
 * This model is really similar to MatchAux but adds the dimension of the Profile.
 *
 * What’s the difference between MatchAux and MatchAuxProfile ?
 * Well, both are really closed but MatchAuxProfile will define optional data
 * related to the Match and to a Profile. This is needed when some extra. information
 * required for this Match are different from a Profile to another.
 *
 * Quantity of data: This model does not usually contains large amount of data since
 * the auxiliary values related to a Match and a Profile are not so common.
 */
class MatchAuxProfile
{
    use DeletableTrait;

    /**
     * @var int
     */
    private $id;

    /**
     * @var Match
     */
    private $match;

    /**
     * @var MatchAuxProfileType
     */
    private $matchAuxProfileType;

    /**
     * @var Profile
     */
    private $profile;

    /**
     * @var string
     */
    private $value;

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Get match.
     *
     * @return Match
     */
    public function getMatch()
    {
        return $this->match;
    }

    /**
     * Set match.
     *
     * @param Match $match
     *
     * @return MatchAuxProfile
     */
    public function setMatch(Match $match)
    {
        $this->match = $match;

        return $this;
    }

    /**
     * Get matchAuxProfileType.
     *
     * @return MatchAuxProfileType
     */
    public function getMatchAuxProfileType()
    {
        return $this->matchAuxProfileType;
    }

    /**
     * Set matchAuxProfileType.
     *
     * @param MatchAuxProfileType $matchAuxProfileType
     *
     * @return MatchAuxProfile
     */
    public function setMatchAuxProfileType(
        MatchAuxProfileType $matchAuxProfileType
    ) {
        $this->matchAuxProfileType = $matchAuxProfileType;

        return $this;
    }

    /**
     * Get profile.
     *
     * @return Profile
     */
    public function getProfile()
    {
        return $this->profile;
    }

    /**
     * Set profile.
     *
     * @param Profile $profile
     *
     * @return MatchAuxProfile
     */
    public function setProfile(Profile $profile)
    {
        $this->profile = $profile;

        return $this;
    }

    /**
     * Get value.
     *
     * @return string
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * Set value.
     *
     * @param string $value
     *
     * @return MatchAuxProfile
     */
    public function setValue($value)
    {
        $this->value = $value;

        return $this;
    }

    /**
     * @return MatchAuxProfile
     */
    public static function create()
    {
        $factory = new MatchAuxProfileFactory();

        return $factory->create();
    }
}
