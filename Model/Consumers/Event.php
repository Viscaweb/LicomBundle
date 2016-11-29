<?php

namespace Visca\Bundle\LicomBundle\Model\Consumers;

use Ramsey\Uuid\Uuid;

final class Event
{
    /** @var string */
    private $eventName;

    /** @var string */
    private $objectId;

    /** @var \DateTimeImmutable */
    private $publishedAt;

    /** @var string */
    private $uniqueId;

    /**
     * Event constructor.
     *
     * @param string                  $eventName
     * @param string|null             $objectId
     * @param \DateTimeImmutable|null $timestamp
     * @param string|null $uniqueId
     */
    public function __construct($eventName, $objectId = null, \DateTimeImmutable $publishedAt = null, $uniqueId = null)
    {
        $this->eventName = $eventName;
        $this->objectId = $objectId;
        $this->publishedAt = $publishedAt ?: new \DateTimeImmutable('now', new \DateTimeZone('UTC'));
        $this->uniqueId = $uniqueId ?: Uuid::uuid4()->toString();
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
    public function getUniqueId()
    {
        return $this->uniqueId;
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
            'uniqueId' => $this->uniqueId
        ]);
    }
}
