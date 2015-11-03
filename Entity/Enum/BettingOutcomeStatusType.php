<?php

namespace Visca\Bundle\LicomBundle\Entity\Enum;

use Fresh\DoctrineEnumBundle\DBAL\Types\AbstractEnumType;

/**
 * Class BettingOutcomeStatusType.
 */
class BettingOutcomeStatusType extends AbstractEnumType
{
    const UNKNOWN = 'unknown';
    const SUCCESS = 'success';
    const FAILED = 'failed';

    /**
     * {@inheritdoc}
     */
    protected $name = 'BettingOutcomeStatusType';

    /**
     * {@inheritdoc}
     */
    protected static $choices = [
        self::UNKNOWN => 'Unknown',
        self::SUCCESS => 'Success',
        self::FAILED => 'Failed',
    ];
}
