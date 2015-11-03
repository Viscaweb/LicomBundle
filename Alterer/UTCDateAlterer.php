<?php

namespace Visca\Bundle\LicomBundle\Alterer;

use DateTime;
use DateTimeZone;
use Visca\Bundle\LicomBundle\Alterer\Interfaces\TimeZoneProviderInterface;

/**
 * Class UTCDateAlterer
 */
class UTCDateAlterer
{
    /**
     * @var TimeZoneProviderInterface Timezone Provider
     */
    private $timezoneProvider;

    /**
     * UTCDateAlterer constructor.
     *
     * @param TimeZoneProviderInterface $timezoneProvider Timezone Provider
     */
    public function __construct(TimeZoneProviderInterface $timezoneProvider)
    {
        $this->timezoneProvider = $timezoneProvider;
    }

    /**
     * @param DateTime $dateTime Date Time Object
     */
    public function alterDateToUtc(DateTime $dateTime)
    {
        $dateTime->setTimezone(new DateTimeZone('UTC'));
    }

    /**
     * @param DateTime $dateTime Date Time Object
     */
    public function alterDateFromUtc(DateTime $dateTime)
    {
        $timezone = $this->timezoneProvider->getTimezone();
        $dateTime->setTimezone(new \DateTimeZone($timezone));
    }
}
