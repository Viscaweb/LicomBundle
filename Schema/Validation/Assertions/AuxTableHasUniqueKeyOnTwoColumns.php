<?php

namespace Visca\Bundle\LicomBundle\Schema\Validation\Assertions;

use SimpleXMLElement;
use Visca\Bundle\LicomBundle\Schema\Validation\Assertions\Abstracts\AbstractKeyAssertion;

/**
 * Class AuxTableHasUniqueKeyOnTwoColumns.
 */
class AuxTableHasUniqueKeyOnTwoColumns extends AbstractKeyAssertion
{
    /**
     * {@inheritdoc}
     */
    public function assertValid(SimpleXMLElement $tableElement)
    {
        $tableName = (string) $tableElement->attributes()['name'];
        if (!preg_match('@_aux$@', $tableName)) {
            return true;
        }

        return $this->assertUniqueKeyWithSpecificColumnsNumber(
            $tableElement,
            2,
            true
        );
    }
}
