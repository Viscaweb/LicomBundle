<?php

namespace Visca\Bundle\LicomBundle\Entity;

use Visca\Bundle\CoreBundle\Entity\Traits\DeletableTrait;

/**
 * StandingCommentGraph.
 */
class StandingCommentGraph
{
    use DeletableTrait;

    /**
     * @var StandingComment
     */
    private $standingComment;

    /**
     * @var StandingCommentGraphLabel
     */
    private $label;

    /**
     * @var StandingRow
     */
    private $standingRow;

    /**
     * Get StandingComment.
     *
     * @return StandingComment
     */
    public function getStandingComment()
    {
        return $this->standingComment;
    }

    /**
     * Set StandingComment.
     *
     * @param StandingComment $standingComment
     *
     * @return StandingCommentGraph
     */
    public function setStandingComment(StandingComment $standingComment)
    {
        $this->standingComment = $standingComment;

        return $this;
    }

    /**
     * Get label.
     *
     * @return StandingCommentGraphLabel
     */
    public function getLabel()
    {
        return $this->label;
    }

    /**
     * Set label.
     *
     * @param StandingCommentGraphLabel $label
     *
     * @return StandingCommentGraph
     */
    public function setLabel(StandingCommentGraphLabel $label)
    {
        $this->label = $label;

        return $this;
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
     * @return StandingCommentGraph
     */
    public function setStandingRow(StandingRow $standingRow)
    {
        $this->standingRow = $standingRow;

        return $this;
    }
}
