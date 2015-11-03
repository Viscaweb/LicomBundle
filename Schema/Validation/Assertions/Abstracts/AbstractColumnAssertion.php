<?php

namespace Visca\Bundle\LicomBundle\Schema\Validation\Assertions\Abstracts;

use SimpleXMLElement;
use Visca\Bundle\LicomBundle\Schema\Validation\Assertions\Interfaces\AssertionInterface;

/**
 * Class AbstractColumnAssertion.
 */
abstract class AbstractColumnAssertion implements AssertionInterface
{
    /**
     * @param SimpleXMLElement $tableElement
     * @param string           $columnName
     *
     * @return bool
     */
    protected function assertColumnNotNull(
        SimpleXMLElement $tableElement,
        $columnName
    ) {
        return $this->assertColumnAttribute(
            $tableElement,
            $columnName,
            'Null',
            'NO'
        );
    }

    /**
     * @param SimpleXMLElement $tableElement
     * @param string           $fieldName
     * @param string           $attributeName
     * @param string           $attributeValue
     * @param bool             $fieldIsMandatory
     *
     * @return bool
     */
    private function assertColumnAttribute(
        SimpleXMLElement $tableElement,
        $fieldName,
        $attributeName,
        $attributeValue,
        $fieldIsMandatory = false
    ) {
        $field = $tableElement->xpath(
            sprintf('./field[@Field="%s"]', $fieldName)
        );
        if (count($field) == 0) {
            if ($fieldIsMandatory) {
                return false;
            } else {
                return true;
            }
        }

        $attribute = (string) $field[0]->attributes()[$attributeName];
        if ($attribute != $attributeValue) {
            return false;
        }

        return true;
    }

    /**
     * @param SimpleXMLElement $tableElement
     * @param string           $columnName
     *
     * @return bool
     */
    protected function assertColumnDefaultEqual(
        SimpleXMLElement $tableElement,
        $columnName,
        $defaultValue
    ) {
        return $this->assertColumnAttribute(
            $tableElement,
            $columnName,
            'Default',
            $defaultValue
        );
    }

    /**
     * @param SimpleXMLElement $tableElement
     * @param string           $columnName
     *
     * @return bool
     */
    protected function assertColumnUnique(
        SimpleXMLElement $tableElement,
        $columnName
    ) {
        return $this->assertColumnAttribute(
            $tableElement,
            $columnName,
            'Key',
            'UNI'
        );
    }

    /**
     * @param SimpleXMLElement $tableElement
     * @param string           $columnName
     *
     * @return bool
     */
    protected function assertColumnDoesNotExist(
        SimpleXMLElement $tableElement,
        $columnName
    ) {
        $field = $tableElement->xpath(
            sprintf('./field[@Field="%s"]', $columnName)
        );

        return count($field) == 0;
    }
}
