<?php

namespace Visca\Bundle\LicomBundle\Entity;

use Visca\Bundle\CoreBundle\Entity\Traits\OptionalDateTimeTrait;
use Visca\Bundle\CoreBundle\Entity\Traits\DeletableTrait;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * StandingComment.
 */
class StandingComment
{
    use OptionalDateTimeTrait;
    use DeletableTrait;

    /**
     * @var int
     */
    private $id;

    /**
     * @var string
     */
    private $text;

    /**
     * @var Collection
     */
    private $standingCommentGraph;

    public function __construct()
    {
        $this->standingCommentGraph = new ArrayCollection();
    }

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
     * Get text.
     *
     * @return string
     */
    public function getText()
    {
        return $this->text;
    }

    /**
     * Set text.
     *
     * @param string $text
     *
     * @return StandingComment
     */
    public function setText($text)
    {
        $this->text = $text;

        return $this;
    }

    /**
     * @return Collection|StandingCommentGraph[]
     */
    public function getStandingCommentGraph()
    {
        return $this->standingCommentGraph;
    }

    /**
     * @param Collection $standingCommentGraph
     *
     * @return $this
     */
    public function setStandingCommentGraph(Collection $standingCommentGraph)
    {
        $this->standingCommentGraph = $standingCommentGraph;

        return $this;
    }

    /**
     * Add StandingCommentGraph.
     *
     * @param StandingCommentGraph $standingCommentGraph
     *
     * @return $this
     */
    public function addStandingCommentGraph(StandingCommentGraph $standingCommentGraph)
    {
        $this->standingCommentGraph[] = $standingCommentGraph;

        return $this;
    }

    /**
     * Remove standingRow.
     *
     * @param StandingRow $standingCommentGraph
     */
    public function removeStandingRow(StandingRow $standingCommentGraph)
    {
        $this->standingCommentGraph->removeElement($standingCommentGraph);
    }
}
