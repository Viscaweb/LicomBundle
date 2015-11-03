<?php

namespace Visca\Bundle\LicomBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Visca\Bundle\LicomBundle\Entity\Traits\GraphLabelTrait;

/**
 * CompetitionRoundGraphLabel.
 */
class CompetitionRoundGraphLabel
{
    use GraphLabelTrait;

    /**
     * @var int
     */
    private $id;

    /**
     * @var Collection
     */
    private $competitionRoundGraph;

    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->competitionRoundGraph = new ArrayCollection();
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
     * Set id.
     *
     * @param int $id
     *
     * @return CompetitionRoundGraphLabel
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Add competitionRoundGraph.
     *
     * @param CompetitionRoundGraph $competitionRoundGraph
     *
     * @return CompetitionRoundGraphLabel
     */
    public function addCompetitionRoundGraph(
        CompetitionRoundGraph $competitionRoundGraph
    ) {
        $this->competitionRoundGraph[] = $competitionRoundGraph;

        return $this;
    }

    /**
     * Remove competitionRoundGraph.
     *
     * @param CompetitionRoundGraph $competitionRoundGraph
     */
    public function removeCompetitionRoundGraph(
        CompetitionRoundGraph $competitionRoundGraph
    ) {
        $this->competitionRoundGraph->removeElement($competitionRoundGraph);
    }

    /**
     * Get competitionRoundGraph.
     *
     * @return Collection
     */
    public function getCompetitionRoundGraph()
    {
        return $this->competitionRoundGraph;
    }
}
