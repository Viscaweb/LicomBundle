<?php

namespace Visca\Bundle\LicomBundle\Entity\Enum;

use Fresh\DoctrineEnumBundle\DBAL\Types\AbstractEnumType;

/**
 * Class MatchIncidentTypeCategory.
 */
class MatchIncidentTypeCategory extends AbstractEnumType
{
    const GOAL = 'goal';
    const CARD = 'card';
    const SUBST = 'subst';
    const SUBST_IN = 'subst_in';
    const UNKNOWN = 'unknown';
    const ASSIST = 'assist';
    const SHOOTOUT = 'shootout';

    /**
     * {@inheritdoc}
     */
    protected $name = 'MatchIncidentTypeCategory';

    /**
     * {@inheritdoc}
     */
    protected static $choices = [
        self::GOAL => 'Goal',
        self::CARD => 'Card',
        self::SUBST => 'Substitution',
        self::SUBST_IN => 'SubstitutionIn',
        self::UNKNOWN => 'Unknown',
        self::ASSIST => 'Assist',
        self::SHOOTOUT => 'Shootout',
    ];
}
