<?php

namespace Visca\Bundle\LicomBundle\Entity;

use Visca\Bundle\CoreBundle\Entity\Traits\DeletableTrait;

/**
 * LocalizationTranslationGraph.
 */
class LocalizationTranslationGraph
{
    use DeletableTrait;

    const DEFAULT_ID = 1;

    /**
     * @var LocalizationTranslationGraphLabel
     */
    private $label;

    /**
     * @var LocalizationTranslation
     */
    private $localizationTranslation;

    /**
     * @var Localization
     */
    private $localization;

    /**
     * Get label.
     */
    public function getLabel()
    {
        return $this->label;
    }

    /**
     * Set label.
     *
     * @param LocalizationTranslationGraphLabel $label
     *
     * @return LocalizationTranslationGraph
     */
    public function setLabel(LocalizationTranslationGraphLabel $label)
    {
        $this->label = $label;

        return $this;
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
     * @return LocalizationTranslationGraph
     */
    public function setLocalizationTranslation(
        LocalizationTranslation $localizationTranslation
    ) {
        $this->localizationTranslation = $localizationTranslation;

        return $this;
    }

    /**
     * Get localization.
     *
     * @return Localization
     */
    public function getLocalization()
    {
        return $this->localization;
    }

    /**
     * Set localization.
     *
     * @param Localization $localization
     *
     * @return LocalizationTranslationGraph
     */
    public function setLocalization(
        Localization $localization
    ) {
        $this->localization = $localization;

        return $this;
    }
}
