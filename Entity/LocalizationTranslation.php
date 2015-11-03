<?php

namespace Visca\Bundle\LicomBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Visca\Bundle\CoreBundle\Entity\Traits\OptionalDateTimeTrait;
use Visca\Bundle\CoreBundle\Entity\Traits\DeletableTrait;

/**
 * LocalizationTranslation.
 *
 * This model simply contains the content of a translation for a given LocalizationTranslationType and the entityId.
 * Note that the relationship to the Entity is made through the relationship with LocalizationTranslationType.
 *
 * Since all the translations will be saved in here, this model usually contains a LARGE amount of rows.
 */
class LocalizationTranslation
{
    use OptionalDateTimeTrait;
    use DeletableTrait;

    /**
     * @var int
     */
    private $id;

    /**
     * @var int
     */
    private $entityId;

    /**
     * @var string|null
     */
    private $text;

    /**
     * @var Collection
     */
    private $localizationTranslationGraph;

    /**
     * @var Collection
     */
    private $profileTranslationGraph;

    /**
     * @var LocalizationTranslationType
     */
    private $localizationTranslationType;

    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->localizationTranslationGraph = new ArrayCollection();
        $this->profileTranslationGraph = new ArrayCollection();
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
     * Get entityId.
     *
     * @return int
     */
    public function getEntityId()
    {
        return $this->entityId;
    }

    /**
     * Set entityId.
     *
     * @param int $entityId
     *
     * @return LocalizationTranslation
     */
    public function setEntityId($entityId)
    {
        $this->entityId = $entityId;

        return $this;
    }

    /**
     * Get text.
     *
     * @return string|null
     */
    public function getText()
    {
        return $this->text;
    }

    /**
     * Set text.
     *
     * @param string|null $text
     *
     * @return LocalizationTranslation
     */
    public function setText($text)
    {
        $this->text = $text;

        return $this;
    }

    /**
     * Add localizationTranslationGraph.
     *
     * @param LocalizationTranslationGraph $localizationTranslationGraph
     *
     * @return LocalizationTranslation
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

    /**
     * Add profileTranslationGraph.
     *
     * @param ProfileTranslationGraph $profileTranslationGraph
     *
     * @return LocalizationTranslation
     */
    public function addProfileTranslationGraph(
        ProfileTranslationGraph $profileTranslationGraph
    ) {
        $this->profileTranslationGraph[] = $profileTranslationGraph;

        return $this;
    }

    /**
     * Remove profileTranslationGraph.
     *
     * @param ProfileTranslationGraph $profileTranslationGraph
     */
    public function removeProfileTranslationGraph(
        ProfileTranslationGraph $profileTranslationGraph
    ) {
        $this->profileTranslationGraph->removeElement($profileTranslationGraph);
    }

    /**
     * Get profileTranslationGraph.
     *
     * @return Collection
     */
    public function getProfileTranslationGraph()
    {
        return $this->profileTranslationGraph;
    }

    /**
     * Get localizationTranslationType.
     *
     * @return LocalizationTranslationType
     */
    public function getLocalizationTranslationType()
    {
        return $this->localizationTranslationType;
    }

    /**
     * Set localizationTranslationType.
     *
     * @param LocalizationTranslationType $localizationTranslationType
     *
     * @return LocalizationTranslation
     */
    public function setLocalizationTranslationType(
        LocalizationTranslationType $localizationTranslationType
    ) {
        $this->localizationTranslationType = $localizationTranslationType;

        return $this;
    }
}
