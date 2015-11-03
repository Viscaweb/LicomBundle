<?php

namespace Visca\Bundle\LicomBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Visca\Bundle\CoreBundle\Entity\Traits\OptionalDateTimeTrait;
use Visca\Bundle\CoreBundle\Entity\Traits\DeletableTrait;

/**
 * Entity.
 *
 * This model Entity wrap and provide an ID for all the others entities:
 *  - Match
 *  - MatchIncident
 *  - MatchResult
 *  - Competition
 *  - CompetitionRound
 *  - Sport
 *  - etc..
 *
 * Quantity of data: This model contains a static number of rows.
 *
 * @example Country
 * @example Competition
 * @example Sport
 */
class Entity
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
    private $code;

    /**
     * @var string
     */
    private $name;

    /**
     * @var Collection
     */
    private $localizationTranslationType;

    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->localizationTranslationType = new ArrayCollection();
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
     * @return Entity
     */
    public function setId($id)
    {
        $this->id = $id;

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
     * @return Entity
     */
    public function setCode($code)
    {
        $this->code = $code;

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
     * @return Entity
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Add localizationTranslationType.
     *
     * @param LocalizationTranslationType $localizationTranslationType
     *
     * @return Entity
     */
    public function addLocalizationTranslationType(
        LocalizationTranslationType $localizationTranslationType
    ) {
        $this->localizationTranslationType[] = $localizationTranslationType;

        return $this;
    }

    /**
     * Remove localizationTranslationType.
     *
     * @param LocalizationTranslationType $localizationTranslationType
     */
    public function removeLocalizationTranslationType(
        LocalizationTranslationType $localizationTranslationType
    ) {
        $this->localizationTranslationType->removeElement(
            $localizationTranslationType
        );
    }

    /**
     * Get localizationTranslationType.
     *
     * @return Collection
     */
    public function getLocalizationTranslationType()
    {
        return $this->localizationTranslationType;
    }
}
