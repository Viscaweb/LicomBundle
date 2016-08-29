<?php

namespace Visca\Bundle\LicomBundle\Model\Consumers;

final class Event
{
    /** @var string */
    private $eventName;

    /** @var string */
    private $objectId;

    /** @var \DateTimeImmutable */
    private $timestamp;

    /**
     * Event constructor.
     *
     * @param string                  $eventName
     * @param string                  $objectId
     * @param \DateTimeImmutable|null $timestamp
     */
    public function __construct($eventName, $objectId, \DateTimeImmutable $timestamp = null)
    {
        $this->eventName = $eventName;
        $this->objectId = $objectId;
        $this->timestamp = $timestamp ?: new \DateTimeImmutable('now', new \DateTimeZone('UTC'));
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

    /**
     * @return \DateTimeImmutable
     */
    public function getTimestamp()
    {
        return $this->timestamp;
    }

    /**
     * @return string
     */
    public function toJson()
    {
        return json_encode([
            'eventName' => $this->eventName,
            'objectId' => $this->objectId,
            'timestamp' => $this->timestamp->format('Y-m-d H:i:s'),
        ]);
    }
}
