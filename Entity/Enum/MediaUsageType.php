<?php

namespace Visca\Bundle\LicomBundle\Entity\Enum;

use Fresh\DoctrineEnumBundle\DBAL\Types\AbstractEnumType;

/**
 * Class MediaUsageType.
 */
class MediaUsageType extends AbstractEnumType
{
    const ICONIFIED = 'iconified';

    /**
     * {@inheritdoc}
     */
    protected $name = 'MediaUsageType';

    /**
     * {@inheritdoc}
     */
    protected static $choices = [
        self::ICONIFIED => 'Iconified',
    ];
}
