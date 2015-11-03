<?php

namespace Visca\Bundle\LicomBundle\Schema\Validation\Assertions;

use SimpleXMLElement;
use Visca\Bundle\LicomBundle\Schema\Validation\Assertions\Abstracts\AbstractColumnAssertion;

/**
 * Class CodeColumnIsUnique.
 */
class CodeColumnIsUnique extends AbstractColumnAssertion
{
    /**
     * {@inheritdoc}
     */
    public function assertValid(SimpleXMLElement $tableElement)
    {
        $field = $tableElement->xpath('./field[@Field="code"]');
        if (count($field) == 0) {
            return true;
        }

        $keys = $tableElement->xpath('./key[@Column_name="code"]');
        if (count($keys) == 0) {
            /*
             * There are no key
             */
            return false;
        }

        $codeUniqueKeyColumnsTotal = [];
        foreach ($keys as $key) {
            $keyName = (string) $key->attributes()['Key_name'];
            if (!isset($codeUniqueKeyColumnsTotal[$keyName])) {
                $codeUniqueKeyColumnsTotal[$keyName] = 0;
            }
            ++$codeUniqueKeyColumnsTotal[$keyName];
        }

        foreach ($codeUniqueKeyColumnsTotal as $columnTotal) {
            if ($columnTotal == 1) {
                /*
                 * There is a key on code column that is composed by only
                 * one column (not multiple)
                 */
                return true;
            }
        }

        return false;
    }
}
