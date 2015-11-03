<?php

namespace Visca\Bundle\LicomBundle\Schema\Validation\Assertions\Abstracts;

use SimpleXMLElement;
use Visca\Bundle\LicomBundle\Schema\Validation\Assertions\Interfaces\AssertionInterface;

/**
 * Class AbstractKeyAssertion.
 */
abstract class AbstractKeyAssertion implements AssertionInterface
{
    /**
     * @param SimpleXMLElement $tableElement
     * @param int              $columnsNumber
     * @param bool             $includePrimaryKey
     */
    protected function assertUniqueKeyWithSpecificColumnsNumber(
        SimpleXMLElement $tableElement,
        $columnsNumber,
        $includePrimaryKey
    ) {
        $keys = $tableElement->xpath('./key[@Non_unique="0"]');
        if (count($keys) == 0) {
            /*
             * There are no key
             */
            return false;
        }

        $codeUniqueKeyColumnsTotal = [];
        foreach ($keys as $key) {
            $keyName = (string) $key->attributes()['Key_name'];
            if (!$includePrimaryKey && $keyName == 'PRIMARY') {
                continue;
            }

            if (!isset($codeUniqueKeyColumnsTotal[$keyName])) {
                $codeUniqueKeyColumnsTotal[$keyName] = 0;
            }
            ++$codeUniqueKeyColumnsTotal[$keyName];
        }

        $hasValidKey = false;
        foreach ($codeUniqueKeyColumnsTotal as $columnsTotal) {
            if ($columnsTotal == $columnsNumber) {
                $hasValidKey = true;
            } else {
                /*
                 * Do not allow any unique key != $columnsTotal
                 */
                return false;
            }
        }

        return $hasValidKey;
    }
}
