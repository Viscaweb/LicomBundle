<?php

namespace Visca\Bundle\LicomBundle\Validator\Constraints;

use Symfony\Component\Validator\Constraint;

/**
 * Class OddsFormatter.
 */
class OddsFormatter extends Constraint
{
    public $message = 'The given formatter ("%formatter%") is not accepted.';

    /**
     * @return string
     */
    public function validatedBy()
    {
        return 'OddsFormatterValidator';
    }
}
