<?php

namespace Visca\Bundle\LicomBundle\Entity\Enum;

use Fresh\DoctrineEnumBundle\DBAL\Types\AbstractEnumType;

/**
 * Class DevicePlatformType.
 */
class DevicePlatformType extends AbstractEnumType
{
    const APNS = 'apns';
    const GCM = 'gcm';

    protected $name = 'DevicePlatformType';

    protected static $choices = [
        self::APNS => self::APNS,
        self::GCM => self::GCM
    ];
}
