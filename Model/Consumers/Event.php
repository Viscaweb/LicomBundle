<?php

namespace Visca\Bundle\LicomBundle\Model\Consumers;

final class Event
{
    /** @var string */
    private $eventName;

    /** @var string */
    private $objectId;

    /**
     * Event constructor.
     *
     * @param string $eventName
     * @param string $objectId
     */
    public function __construct($eventName, $objectId)
    {
        $this->eventName = $eventName;
        $this->objectId = $objectId;
    }

    /**
     * @return string
     */
    public function getEventName()
    {
        return $this->eventName;
    }

    /**
     * @return string
     */
    public function getObjectId()
    {
        return $this->objectId;
    }
}
