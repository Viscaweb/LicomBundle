<?php

namespace Visca\Bundle\LicomBundle\Entity\Enum;

use Fresh\DoctrineEnumBundle\DBAL\Types\AbstractEnumType;

/**
 * Class MatchWinnerType.
 *
 * The value is the MatchParticipant::number
 */
class MatchWinnerType extends AbstractEnumType
{
    const HOME = '1';
    const DRAW = '0';
    const AWAY = '2';

    /**
     * {@inheritdoc}
     */
    protected $name = 'MatchWinnerType';

    /**
     * {@inheritdoc}
     */
    protected static $choices = [
        self::HOME => 'Home participant',
        self::DRAW => 'Draw',
        self::AWAY => 'Away participant',
    ];
}
