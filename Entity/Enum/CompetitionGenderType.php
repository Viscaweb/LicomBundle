<?php

namespace Visca\Bundle\LicomBundle\Entity\Enum;

use Fresh\DoctrineEnumBundle\DBAL\Types\AbstractEnumType;

/**
 * Class CompetitionGenderType.
 */
class CompetitionGenderType extends AbstractEnumType
{
    const UNDEFINED = 'undefined';
    const MALE = 'male';
    const FEMALE = 'female';
    const MIXED = 'mixed';

    /**
     * {@inheritdoc}
     */
    protected $name = 'CompetitionGenderType';

    /**
     * {@inheritdoc}
     */
    protected static $choices = [
        self::UNDEFINED => 'Undefined',
        self::MALE => 'Male',
        self::FEMALE => 'Female',
        self::MIXED => 'Mixed',
    ];
}
