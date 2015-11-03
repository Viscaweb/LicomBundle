<?php

namespace Visca\Bundle\LicomViewBundle\Generator\View;

use Visca\Bundle\LicomBundle\Entity\StandingRow;
use Visca\Bundle\SportBundle\Model\StandingViewTable;

/**
 * Class StandingRowToStandingViewTable.
 */
class StandingViewTableFromStandingRow
{
    /**
     * Converts an array of StandingRows to a StandingViewTable.
     *
     * @param StandingRow[] $standingRows   Array of Standing Rows.
     * @param string[]      $forcedXHeaders Array of strings to use as x headers.
     * @param string[]      $forcedYHeaders Array of strings to use as y headers.
     *
     * @return StandingViewTable
     */
    public function fromStandingRow(
        array $standingRows,
        array $forcedXHeaders = array(),
        array $forcedYHeaders = array()
    ) {
        $table = new StandingViewTable();
        if (isset($forcedYHeaders[0])) {
            $table->addHeader($forcedYHeaders[0]);
        }

        if (count($standingRows) > 0) {
            foreach ($standingRows as $idx => $standingRow) {
                $dataRow = [];
                if (isset($forcedXHeaders[$idx])) {
                    $dataRow[] = $standingRow->getId().'-'.$forcedXHeaders[$idx];
                } else {
                    $dataRow[] = $standingRow->getId();
                }

                $cells = $standingRow->getStandingCell();

                // Protect against empty cells
                if ($cells->count() > 0) {
                    foreach ($cells as $cell) {
                        if ($idx === 0) {
                            $table->addHeader(
                                $cell->getStandingColumn()->getName()
                            );
                        }

                        $dataRow[] = $cell->getValue();
                    }
                    $table->addRow($dataRow);
                }
            }
        }

        return $table;
    }
}
