<?php

namespace Visca\Bundle\LicomBundle\Entity;

use Visca\Bundle\CoreBundle\Entity\Traits\OptionalDateTimeTrait;
use Visca\Bundle\CoreBundle\Entity\Traits\DeletableTrait;

/**
 * StandingView.
 *
 * This model helps constructing a standing table.
 * To get more information about this model and how it operates, take a look on the Standing model.
 *
 * @link http://bit.ly/StandingViewSoccer Standing Views for the Soccer
 */
class StandingView
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
    private $description;

    /**
     * @var Entity
     */
    private $entity;

    /**
     * @var Entity
     */
    private $scopeEntity;

    /**
     * @var int
     */
    private $scopeEntityId;

    /**
     * @var int|null
     */
    private $position;

    /**
     * @var string|null
     */
    private $extraMethod;

    /**
     * @var StandingType
     */
    private $standingType;

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
     * @return StandingView
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
     * @return StandingView
     */
    public function setCode($code)
    {
        $this->code = $code;

        return $this;
    }

    /**
     * Get description.
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set description.
     *
     * @param string $description
     *
     * @return StandingView
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get Entity.
     *
     * @return Entity
     */
    public function getEntity()
    {
        return $this->entity;
    }

    /**
     * Set Entity.
     *
     * @param Entity $entity
     *
     * @return StandingView
     */
    public function setEntity(Entity $entity)
    {
        $this->entity = $entity;

        return $this;
    }

    /**
     * Get scopeEntity.
     *
     * @return Entity
     */
    public function getScopeEntity()
    {
        return $this->scopeEntity;
    }

    /**
     * Set scopeEntity.
     *
     * @param Entity $scopeEntity
     *
     * @return StandingView
     */
    public function setScopeEntity(Entity $scopeEntity)
    {
        $this->scopeEntity = $scopeEntity;

        return $this;
    }

    /**
     * Get scopeEntityId.
     *
     * @return int
     */
    public function getScopeEntityId()
    {
        return $this->scopeEntityId;
    }

    /**
     * Set scopeEntityId.
     *
     * @param int $scopeEntityId
     *
     * @return StandingView
     */
    public function setScopeEntityId($scopeEntityId)
    {
        $this->scopeEntityId = $scopeEntityId;

        return $this;
    }

    /**
     * Get position.
     *
     * @return int|null
     */
    public function getPosition()
    {
        return $this->position;
    }

    /**
     * Set position.
     *
     * @param int|null $position
     *
     * @return StandingView
     */
    public function setPosition($position)
    {
        $this->position = $position;

        return $this;
    }

    /**
     * Get extraMethod.
     *
     * @return string|null
     */
    public function getExtraMethod()
    {
        return $this->extraMethod;
    }

    /**
     * Set extraMethod.
     *
     * @param string|null $extraMethod
     *
     * @return StandingView
     */
    public function setExtraMethod($extraMethod)
    {
        $this->extraMethod = $extraMethod;

        return $this;
    }

    /**
     * Get StandingType.
     *
     * @return StandingType
     */
    public function getStandingType()
    {
        return $this->standingType;
    }

    /**
     * Set StandingType.
     *
     * @param StandingType $standingType
     *
     * @return StandingView
     */
    public function setStandingType(StandingType $standingType)
    {
        $this->standingType = $standingType;

        return $this;
    }
}
