<?php

namespace Visca\Bundle\LicomBundle\Entity;

use Visca\Bundle\CoreBundle\Entity\Traits\OptionalDateTimeTrait;
use Visca\Bundle\CoreBundle\Entity\Traits\DeletableTrait;
use Visca\Bundle\LicomBundle\Factory\StandingCellFactory;

/**
 * StandingCell.
 *
 * This model contains the value of a given ranking.
 * To get more information about this model and how it operates, take a look on the Standing model.
 *
 * Quantity of data: This model define the value for all the standing.
 * This model usually contains a LARGE amount of rows.
 */
class StandingCell
{
    use OptionalDateTimeTrait;
    use DeletableTrait;

    /**
     * @var int
     */
    private $id;

    /**
     * @var StandingRow
     */
    private $standingRow;

    /**
     * @var StandingColumn
     */
    private $standingColumn;

    /**
     * @var float
     */
    private $value;

    /**
     * Get id.
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Get StandingRow.
     *
     * @return StandingRow
     */
    public function getStandingRow()
    {
        return $this->standingRow;
    }

    /**
     * Set StandingRow.
     *
     * @param StandingRow $standingRow
     *
     * @return StandingCell
     */
    public function setStandingRow(StandingRow $standingRow)
    {
        $this->standingRow = $standingRow;

        return $this;
    }

    /**
     * Get StandingColumn.
     *
     * @return StandingColumn
     */
    public function getStandingColumn()
    {
        return $this->standingColumn;
    }

    /**
     * Set StandingColumn.
     *
     * @param StandingColumn $standingColumn
     *
     * @return StandingCell
     */
    public function setStandingColumn(StandingColumn $standingColumn)
    {
        $this->standingColumn = $standingColumn;

        return $this;
    }

    /**
     * Get value.
     *
     * @return float
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * Set value.
     *
     * @param float $value
     *
     * @return StandingCell
     */
    public function setValue($value)
    {
        $this->value = $value;

        return $this;
    }

    /**
     * @return StandingCell
     */
    public static function create()
    {
        $factory = new StandingCellFactory();

        return $factory->create();
    }
}
