<?php

namespace Visca\Bundle\LicomBundle\Schema\Validation;

use SimpleXMLElement;
use Visca\Bundle\LicomBundle\Schema\Validation\Assertions\AuxTableHasUniqueKeyOnTwoColumns;
use Visca\Bundle\LicomBundle\Schema\Validation\Assertions\CodeColumnIsUnique;
use Visca\Bundle\LicomBundle\Schema\Validation\Assertions\DelColumnDefaultValueIsNo;
use Visca\Bundle\LicomBundle\Schema\Validation\Assertions\DelColumnIsNotNullable;
use Visca\Bundle\LicomBundle\Schema\Validation\Assertions\GraphAndAuxTablesDoNotHaveAnIdColumn;
use Visca\Bundle\LicomBundle\Schema\Validation\Assertions\GraphTableHasPrimaryKeyOnThreeColumns;
use Visca\Bundle\LicomBundle\Schema\Validation\Assertions\Interfaces\AssertionInterface;
use Visca\Bundle\LicomBundle\Schema\Validation\Assertions\StaticTablesColumnIdShouldNotBeAutoIncremented;

/**
 * Validate the schema about conventions we use.
 */
class SchemaValidator
{
    /**
     * @var AssertionInterface[]
     */
    private $assertions;

    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->assertions = [];
        $this->assertions[] = new DelColumnIsNotNullable();
        $this->assertions[] = new DelColumnDefaultValueIsNo();
        $this->assertions[] = new CodeColumnIsUnique();
        $this->assertions[] = new GraphTableHasPrimaryKeyOnThreeColumns();
        $this->assertions[] = new AuxTableHasUniqueKeyOnTwoColumns();
        $this->assertions[] = new GraphAndAuxTablesDoNotHaveAnIdColumn();
        $this->assertions[] = new StaticTablesColumnIdShouldNotBeAutoIncremented();
    }

    /**
     * @param SimpleXMLElement $rootXmlElement
     *
     * @return array
     */
    public function validate(SimpleXMLElement $rootXmlElement)
    {
        $report = [];

        foreach ($rootXmlElement->database as $database) {
            foreach ($database->table_structure as $tableStructure) {
                $tableName = (string) $tableStructure->attributes()['name'];

                $issues = [];
                foreach ($this->assertions as $assertion) {
                    if (!$assertion->assertValid($tableStructure)) {
                        $issues[] = get_class($assertion);
                    }
                }

                if (count($issues) > 0) {
                    $report[$tableName] = $issues;
                }
            }
        }

        return $report;
    }
}
