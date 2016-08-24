<?php

namespace Visca\Bundle\LicomBundle\Entity\Value;

/**
 * Class MatchAuxProfileValue.
 *
 * This class is to enumerate all the types of ProfileValues
 * Is not a DB enum field, its only to not use strings inside the code.
 */
class MatchAuxProfileValue
{
    const IMPORTANT = 'important';
    const TOP = 'top';
    const SECOND = '2nd';
}
