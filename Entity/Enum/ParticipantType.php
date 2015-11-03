<?php

namespace Visca\Bundle\LicomBundle\Entity\Enum;

use Fresh\DoctrineEnumBundle\DBAL\Types\AbstractEnumType;

/**
 * Class ParticipantType.
 */
class ParticipantType extends AbstractEnumType
{
    const TEAM = 'team';
    const OFFICIAL = 'official';
    const UNDEFINED = 'undefined';
    const COACH = 'coach';
    const ATHLETE = 'athlete';
    const ORGANIZATION = 'organization';

    /**
     * {@inheritdoc}
     */
    protected $name = 'ParticipantType';

    /**
     * {@inheritdoc}
     */
    protected static $choices = [
        self::TEAM => 'Team',
        self::OFFICIAL => 'Official',
        self::UNDEFINED => 'Undefined',
        self::COACH => 'Coach',
        self::ATHLETE => 'Athlete',
        self::ORGANIZATION => 'Organization',
    ];
}
