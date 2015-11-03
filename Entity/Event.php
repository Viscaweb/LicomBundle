<?php

namespace Visca\Bundle\LicomBundle\Entity;

use Visca\Bundle\CoreBundle\Entity\Traits\OptionalDateTimeTrait;
use Visca\Bundle\CoreBundle\Entity\Traits\DeletableTrait;

/**
 * Event.
 */
class Event
{
    use OptionalDateTimeTrait;
    use DeletableTrait;

    /**
     * @var int
     */
    private $id;

    /**
     * @var Entity
     */
    private $entity;

    /**
     * @var int
     */
    private $entityId;

    /**
     * @var EventType
     */
    private $eventType;

    /**
     * @var array|null
     */
    private $property;

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
     * @return Event
     */
    public function setEntity(Entity $entity)
    {
        $this->entity = $entity;

        return $this;
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
     * @return Event
     */
    public function setEntityId($entityId)
    {
        $this->entityId = $entityId;

        return $this;
    }

    /**
     * Get EventType.
     *
     * @return EventType
     */
    public function getEventType()
    {
        return $this->eventType;
    }

    /**
     * Set EventType.
     *
     * @param EventType $eventType
     *
     * @return Event
     */
    public function setEventType(EventType $eventType)
    {
        $this->eventType = $eventType;

        return $this;
    }

    /**
     * @return array|null
     */
    public function getProperty()
    {
        return $this->property;
    }

    /**
     * @param array|null $property
     *
     * @return Event
     */
    public function setProperty(array $property = null)
    {
        $this->property = $property;

        return $this;
    }
}
