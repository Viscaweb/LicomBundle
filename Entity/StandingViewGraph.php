<?php

namespace Visca\Bundle\LicomBundle\Entity;

use Visca\Bundle\CoreBundle\Entity\Traits\DeletableTrait;

/**
 * StandingViewGraph.
 *
 * For more information, please refer to StandingView.
 */
class StandingViewGraph
{
    use DeletableTrait;

    /**
     * @var StandingView
     */
    private $standingView;

    /**
     * @var StandingViewGraphLabel
     */
    private $label;

    /**
     * @var StandingColumn
     */
    private $standingColumn;

    /**
     * @var int|null
     */
    private $position;

    /**
     * Get StandingView.
     *
     * @return StandingView
     */
    public function getStandingView()
    {
        return $this->standingView;
    }

    /**
     * Set StandingView.
     *
     * @param StandingView $standingView
     *
     * @return StandingViewGraph
     */
    public function setStandingView(StandingView $standingView)
    {
        $this->standingView = $standingView;

        return $this;
    }

    /**
     * Get label.
     *
     * @return StandingViewGraphLabel
     */
    public function getLabel()
    {
        return $this->label;
    }

    /**
     * Set label.
     *
     * @param StandingViewGraphLabel $label
     *
     * @return StandingViewGraph
     */
    public function setLabel(StandingViewGraphLabel $label)
    {
        $this->label = $label;

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
     * @return StandingViewGraph
     */
    public function setStandingColumn(StandingColumn $standingColumn)
    {
        $this->standingColumn = $standingColumn;

        return $this;
    }

    /**
     * Get position.
     *
     * @return int|null
     */
    public function getPosition()
    {
        return $this->position;
    }

    /**
     * Set position.
     *
     * @param int|null $position
     *
     * @return StandingViewGraph
     */
    public function setPosition($position)
    {
        $this->position = $position;

        return $this;
    }
}
