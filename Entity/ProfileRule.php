<?php

namespace Visca\Bundle\LicomBundle\Entity;

use Visca\Bundle\CoreBundle\Entity\Traits\OptionalDateTimeTrait;
use Visca\Bundle\CoreBundle\Entity\Traits\DeletableTrait;

/**
 * ProfileRule.
 */
class ProfileRule
{
    use OptionalDateTimeTrait;
    use DeletableTrait;

    /**
     * @var int
     */
    private $id;

    /**
     * @var Profile
     */
    private $profile;

    /**
     * @var ProfileRuleType
     */
    private $profileRuleType;

    /**
     * @var string
     */
    private $value;

    /**
     * @var int
     */
    private $position;

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Get Profile.
     *
     * @return Profile
     */
    public function getProfile()
    {
        return $this->profile;
    }

    /**
     * Set Profile.
     *
     * @param Profile $profile
     *
     * @return ProfileRule
     */
    public function setProfile(Profile $profile)
    {
        $this->profile = $profile;

        return $this;
    }

    /**
     * Get ProfileRuleType.
     *
     * @return ProfileRuleType
     */
    public function getProfileRuleType()
    {
        return $this->profileRuleType;
    }

    /**
     * Set ProfileRuleType.
     *
     * @param ProfileRuleType $profileRuleType
     *
     * @return ProfileRule
     */
    public function setProfileRuleType(ProfileRuleType $profileRuleType)
    {
        $this->profileRuleType = $profileRuleType;

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
     * @return ProfileRule
     */
    public function setValue($value)
    {
        $this->value = $value;

        return $this;
    }

    /**
     * Get position.
     *
     * @return int
     */
    public function getPosition()
    {
        return $this->position;
    }

    /**
     * Set position.
     *
     * @param int $position
     *
     * @return ProfileRule
     */
    public function setPosition($position)
    {
        $this->position = $position;

        return $this;
    }
}
