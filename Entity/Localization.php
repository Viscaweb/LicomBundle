<?php

namespace Visca\Bundle\LicomBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Visca\Bundle\CoreBundle\Entity\Traits\OptionalDateTimeTrait;
use Visca\Bundle\CoreBundle\Entity\Traits\DeletableTrait;

/**
 * Localization.
 *
 * This model define a zone in the world (language + country) and is used to define translations.
 *
 * This model contains a static number of rows.
 *
 * There are two kind of localizations:
 * 1/ Those assign to a language (FR, BR, ES, etc…) (having the `country` field set to NULL)
 * 2/ Those assign to a language and a country (FR-FR, FR-CA, ES-ES, etc..) overriding 1/
 */
class Localization
{
    use OptionalDateTimeTrait;
    use DeletableTrait;

    /**
     * @var int
     */
    private $id;

    /**
     * @var string
     */
    private $language;

    /**
     * @var string|null
     */
    private $country;

    /**
     * @var Collection
     */
    private $localizationTranslationGraph;

    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->localizationTranslationGraph = new ArrayCollection();
    }

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
     * @return Localization
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Get language.
     *
     * @return string
     */
    public function getLanguage()
    {
        return $this->language;
    }

    /**
     * Set language.
     *
     * @param string $language
     *
     * @return Localization
     */
    public function setLanguage($language)
    {
        $this->language = $language;

        return $this;
    }

    /**
     * Get country.
     *
     * @return string|null
     */
    public function getCountry()
    {
        return $this->country;
    }

    /**
     * Set country.
     *
     * @param string|null $country
     *
     * @return Localization
     */
    public function setCountry($country)
    {
        $this->country = $country;

        return $this;
    }

    /**
     * Add localizationTranslationGraph.
     *
     * @param LocalizationTranslationGraph $localizationTranslationGraph
     *
     * @return Localization
     */
    public function addLocalizationTranslationGraph(
        LocalizationTranslationGraph $localizationTranslationGraph
    ) {
        $this->localizationTranslationGraph[] = $localizationTranslationGraph;

        return $this;
    }

    /**
     * Remove localizationTranslationGraph.
     *
     * @param LocalizationTranslationGraph $localizationTranslationGraph
     */
    public function removeLocalizationTranslationGraph(
        LocalizationTranslationGraph $localizationTranslationGraph
    ) {
        $this->localizationTranslationGraph->removeElement(
            $localizationTranslationGraph
        );
    }

    /**
     * Get localizationTranslationGraph.
     *
     * @return Collection
     */
    public function getLocalizationTranslationGraph()
    {
        return $this->localizationTranslationGraph;
    }
}
