<?php

namespace Visca\Bundle\LicomBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Visca\Bundle\CoreBundle\Entity\Traits\OptionalDateTimeTrait;
use Visca\Bundle\CoreBundle\Entity\Traits\DeletableTrait;

/**
 * LocalizationTranslationType.
 */
class LocalizationTranslationType
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
    private $localizationTranslation;

    /**
     * @var Entity
     */
    private $entity;

    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->localizationTranslation = new ArrayCollection();
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
     * @return LocalizationTranslationType
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
     * @return LocalizationTranslationType
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
     * @return LocalizationTranslationType
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Add localizationTranslation.
     *
     * @param LocalizationTranslation $localizationTranslation
     *
     * @return LocalizationTranslationType
     */
    public function addLocalizationTranslation(
        LocalizationTranslation $localizationTranslation
    ) {
        $this->localizationTranslation[] = $localizationTranslation;

        return $this;
    }

    /**
     * Remove localizationTranslation.
     *
     * @param LocalizationTranslation $localizationTranslation
     */
    public function removeLocalizationTranslation(
        LocalizationTranslation $localizationTranslation
    ) {
        $this->localizationTranslation->removeElement($localizationTranslation);
    }

    /**
     * Get localizationTranslation.
     *
     * @return Collection
     */
    public function getLocalizationTranslation()
    {
        return $this->localizationTranslation;
    }

    /**
     * Get entity.
     *
     * @return Entity
     */
    public function getEntity()
    {
        return $this->entity;
    }

    /**
     * Set entity.
     *
     * @param Entity $entity
     *
     * @return LocalizationTranslationType
     */
    public function setEntity(Entity $entity)
    {
        $this->entity = $entity;

        return $this;
    }
}
