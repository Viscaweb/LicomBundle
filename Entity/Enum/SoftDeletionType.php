<?php

namespace Visca\Bundle\LicomBundle\Entity\Enum;

use Fresh\DoctrineEnumBundle\DBAL\Types\AbstractEnumType;

/**
 * Class SoftDeletionType.
 */
class SoftDeletionType extends AbstractEnumType
{
    const YES = 'yes';
    const NO = 'no';

    /**
     * {@inheritdoc}
     */
    protected $name = 'SoftDeletionType';

    /**
     * {@inheritdoc}
     */
    protected static $choices = [
        self::YES => 'Yes',
        self::NO => 'No',
    ];
}
