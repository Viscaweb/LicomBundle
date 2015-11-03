<?php

namespace Visca\Bundle\LicomBundle\Entity;

use Visca\Bundle\CoreBundle\Entity\Traits\DeletableTrait;

/**
 * ProfileTranslationGraph.
 */
class ProfileTranslationGraph
{
    use DeletableTrait;

    /**
     * @var int
     */
    private $id;

    /**
     * @var LocalizationTranslation
     */
    private $localizationTranslation;

    /**
     * @var Profile
     */
    private $profile;

    /**
     * @var ProfileTranslationGraphLabel
     */
    private $profileTranslationGraphLabel;

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
     * Get localizationTranslation.
     *
     * @return LocalizationTranslation
     */
    public function getLocalizationTranslation()
    {
        return $this->localizationTranslation;
    }

    /**
     * Set localizationTranslation.
     *
     * @param LocalizationTranslation $localizationTranslation
     *
     * @return ProfileTranslationGraph
     */
    public function setLocalizationTranslation(
        LocalizationTranslation $localizationTranslation
    ) {
        $this->localizationTranslation = $localizationTranslation;

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
     * @return ProfileTranslationGraph
     */
    public function setProfile(
        Profile $profile
    ) {
        $this->profile = $profile;

        return $this;
    }

    /**
     * Get profileTranslationGraphLabel.
     *
     * @return ProfileTranslationGraphLabel
     */
    public function getProfileTranslationGraphLabel()
    {
        return $this->profileTranslationGraphLabel;
    }

    /**
     * Set profileTranslationGraphLabel.
     *
     * @param ProfileTranslationGraphLabel $profileTranslationGraphLabel
     *
     * @return ProfileTranslationGraph
     */
    public function setProfileTranslationGraphLabel(
        ProfileTranslationGraphLabel $profileTranslationGraphLabel
    ) {
        $this->profileTranslationGraphLabel = $profileTranslationGraphLabel;

        return $this;
    }
}
