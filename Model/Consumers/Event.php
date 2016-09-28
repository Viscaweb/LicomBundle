<?php

namespace Visca\Bundle\LicomBundle\Model\Consumers;

final class Event
{
    /** @var string */
    private $eventName;

    /** @var string */
    private $objectId;

    /** @var \DateTimeImmutable */
    private $publishedAt;

    /**
     * Event constructor.
     *
     * @param string                  $eventName
     * @param string                  $objectId
     * @param \DateTimeImmutable|null $timestamp
     */
    public function __construct($eventName, $objectId = null, \DateTimeImmutable $publishedAt = null)
    {
        $this->eventName = $eventName;
        $this->objectId = $objectId;
        $this->publishedAt = $publishedAt ?: new \DateTimeImmutable('now', new \DateTimeZone('UTC'));
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
    public function getPublishedAt()
    {
        return $this->publishedAt;
    }

    /**
     * @return string
     */
    public function toJson()
    {
        return json_encode([
            'eventName' => $this->eventName,
            'objectId' => $this->objectId,
            'publishedAt' => $this->publishedAt->format('Y-m-d H:i:s'),
        ]);
    }
}
