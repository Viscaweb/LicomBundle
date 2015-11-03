<?php

namespace Visca\Bundle\LicomBundle\Schema\Validation\Assertions;

use SimpleXMLElement;
use Visca\Bundle\LicomBundle\Schema\Validation\Assertions\Abstracts\AbstractColumnAssertion;

/**
 * Class StaticTablesColumnIdShouldNotBeAutoIncremented.
 */
class StaticTablesColumnIdShouldNotBeAutoIncremented extends AbstractColumnAssertion
{
    /**
     * {@inheritdoc}
     */
    public function assertValid(SimpleXMLElement $tableElement)
    {
        $tableName = (string) $tableElement->attributes()['name'];

        if (!$this->isTableAStaticTable($tableName)) {
            return true;
        }

        $primaryKeyFields = $tableElement->xpath('./field[@Key="PRI"]');
        if (count($primaryKeyFields) == 0) {
            return false;
        }

        foreach ($primaryKeyFields as $primaryKeyField) {
            $extra = (string) $primaryKeyField->attributes()['Extra'];

            if ($extra == 'auto_increment') {
                return false;
            }
        }

        return true;
    }

    /**
     * @param string $tableName
     *
     * @return bool
     */
    private function isTableAStaticTable($tableName)
    {
        $tableNamesPatterns = [
            'label$',
            'Type$',
            '^MatchStatusDescription$',
            '^StandingPromotion$',
            '^StandingView$',
            '^Profile$',
            '^Sport$',
        ];

        foreach ($tableNamesPatterns as $tableNamesPattern) {
            if (preg_match('@'.$tableNamesPattern.'@', $tableName)) {
                return true;
            }
        }

        return false;
    }
}
