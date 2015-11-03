<?php

namespace Visca\Bundle\LicomBundle\Entity\Enum;

use Fresh\DoctrineEnumBundle\DBAL\Types\AbstractEnumType;

/**
 * Class ParticipantMembershipParticipantType.
 */
class ParticipantMembershipParticipantType extends AbstractEnumType
{
    const COACH = 'coach';
    const TEAM = 'team';
    const ASSISTANT = 'assistant';
    const MANAGER = 'manager';
    const ATHLETE = 'athlete';

    /**
     * {@inheritdoc}
     */
    protected $name = 'ParticipantMembershipParticipantType';

    /**
     * {@inheritdoc}
     */
    protected static $choices = [
        self::COACH => 'Coach',
        self::TEAM => 'Team',
        self::ASSISTANT => 'Assistant',
        self::MANAGER => 'Manager',
        self::ATHLETE => 'Athlete',
    ];
}
