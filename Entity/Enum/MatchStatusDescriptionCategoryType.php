<?php

namespace Visca\Bundle\LicomBundle\Entity\Enum;

use Fresh\DoctrineEnumBundle\DBAL\Types\AbstractEnumType;

/**
 * Class MatchStatusDescriptionCategoryType.
 */
class MatchStatusDescriptionCategoryType extends AbstractEnumType
{
    const NOTSTARTED = 'notstarted';
    const INPROGRESS = 'inprogress';
    const FINISHED = 'finished';
    const CANCELLED = 'cancelled';
    const INTERRUPTED = 'interrupted';
    const UNKNOWN = 'unknown';
    const DELETED = 'deleted';

    /**
     * {@inheritdoc}
     */
    protected $name = 'MatchStatusDescriptionCategoryType';

    /**
     * {@inheritdoc}
     */
    protected static $choices = [
        self::NOTSTARTED => 'Not started',
        self::INPROGRESS => 'In progress',
        self::FINISHED => 'Finished',
        self::CANCELLED => 'Cancelled',
        self::INTERRUPTED => 'Interrupted',
        self::UNKNOWN => 'Unknown',
        self::DELETED => 'Deleted',
    ];
}
