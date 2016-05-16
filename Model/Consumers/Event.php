<?php

namespace Model\Consumers;

class Event
{
    /** @var string */
    private $eventName;

    /**
     * Event constructor.
     *
     * @param string $eventName
     */
    public function __construct($eventName)
    {
        $this->eventName = $eventName;
    }

    /**
     * @return string
     */
    public function getEventName()
    {
        return $this->eventName;
    }
}
