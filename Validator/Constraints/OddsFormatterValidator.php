<?php

namespace Visca\Bundle\LicomBundle\Validator\Constraints;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Visca\Bundle\LicomBundle\Services\Chain\OddsFormatterChain;

/**
 * Class OddsFormatterValidator.
 */
class OddsFormatterValidator extends ConstraintValidator
{
    /**
     * @var string[] Contains all the valid odds formatter
     */
    protected $validOddsFormatter;

    /**
     * OddsFormatterType constructor.
     *
     * @param OddsFormatterChain $oddsFormatterChain Odds Formatter Chain
     */
    public function __construct(OddsFormatterChain $oddsFormatterChain)
    {
        foreach ($oddsFormatterChain->all() as $oddsFormatterKey => $oddsFormatter) {
            $this->validOddsFormatter[] = $oddsFormatterKey;
        }
    }

    /**
     * Checks if the passed odds formatter is valid and exists.
     *
     * @param mixed      $value      The value that should be validated
     * @param Constraint $constraint The constraint for the validation
     *
     * @api
     */
    public function validate($value, Constraint $constraint)
    {
        if (!in_array($value, $this->validOddsFormatter)) {
            $this->context->addViolation(
                $constraint->message,
                ['%formatter%' => $value]
            );
        }
    }
}
