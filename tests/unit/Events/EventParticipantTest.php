<?php

use Visca\Bundle\LicomBundle\Events\Event;

class EventParticipantTest extends PHPUnit_Framework_TestCase
{
    /**
     * @param string $listenTo
     * @param string $listenBy
     * @param mixed  $object
     * @param string $expectedEventName
     *
     * @dataProvider listOfEvents
     */
    public function test($listenTo, $listenBy, $object, $expectedEventName)
    {
        /** @var Event $event */
        $event = $listenTo::$listenBy($object);
        $this->assertEquals($event->getName(), $expectedEventName);
    }

    /**
     * @return array
     */
    public function listOfEvents()
    {
        $participantEvent = '\Visca\Bundle\LicomBundle\Events\Participant';

        return [
            // Participant
            [$participantEvent, 'listenBySport', 1, 'participant@sport.1'],
        ];
    }
}
