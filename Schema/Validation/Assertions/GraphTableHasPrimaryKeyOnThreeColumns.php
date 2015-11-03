<?php

namespace Visca\Bundle\LicomBundle\Schema\Validation\Assertions;

use SimpleXMLElement;
use Visca\Bundle\LicomBundle\Schema\Validation\Assertions\Abstracts\AbstractKeyAssertion;

/**
 * Class GraphTableHasPrimaryKeyOnThreeColumns.
 */
class GraphTableHasPrimaryKeyOnThreeColumns extends AbstractKeyAssertion
{
    /**
     * {@inheritdoc}
     */
    public function assertValid(SimpleXMLElement $tableElement)
    {
        $tableName = (string) $tableElement->attributes()['name'];
        if (!preg_match('@_graph$@', $tableName)) {
            return true;
        }

        /*
         * Exception
         */
        if ($tableName == 'ProfileEntity_graph') {
            return $this->assertUniqueKeyWithSpecificColumnsNumber(
                $tableElement,
                4,
                true
            );
        } else {
            return $this->assertUniqueKeyWithSpecificColumnsNumber(
                $tableElement,
                3,
                true
            );
        }
    }
}
