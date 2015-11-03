<?php

namespace Visca\Bundle\LicomBundle\Entity\Enum;

use Fresh\DoctrineEnumBundle\DBAL\Types\AbstractEnumType;

/**
 * Class MediaLegalType.
 */
class MediaLegalType extends AbstractEnumType
{
    const OFFICIAL = 'official';
    const UNOFFICIAL = 'unofficial';

    /**
     * {@inheritdoc}
     */
    protected $name = 'MediaLegalType';

    /**
     * {@inheritdoc}
     */
    protected static $choices = [
        self::OFFICIAL => 'Official',
        self::UNOFFICIAL => 'Unofficial',
    ];
}
