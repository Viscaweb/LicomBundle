<?php

namespace Visca\Bundle\LicomBundle\Schema\Validation\Assertions;

use SimpleXMLElement;
use Visca\Bundle\LicomBundle\Schema\Validation\Assertions\Abstracts\AbstractColumnAssertion;

/**
 * Class GraphAndAuxTablesDoNotHaveAnIdColumn.
 */
class GraphAndAuxTablesDoNotHaveAnIdColumn extends AbstractColumnAssertion
{
    /**
     * {@inheritdoc}
     */
    public function assertValid(SimpleXMLElement $tableElement)
    {
        $tableName = (string) $tableElement->attributes()['name'];
        if (!preg_match('@_aux$@', $tableName)
            && !preg_match('@_graph$@', $tableName)
        ) {
            return true;
        }

        return $this->assertColumnDoesNotExist($tableElement, 'id');
    }
}
