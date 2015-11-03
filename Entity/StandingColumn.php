<?php

namespace Visca\Bundle\LicomBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Visca\Bundle\CoreBundle\Entity\Traits\DeletableTrait;
use Visca\Bundle\CoreBundle\Entity\Traits\OptionalDateTimeTrait;

/**
 * StandingColumn.
 *
 * This model contains the columns to display when constructing a given type of standing.
 * To get more information about this model and how it operates, take a look on the Standing model.
 */
class StandingColumn
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
    private $code;

    /**
     * @var string
     */
    private $name;

    /**
     * @var Collection
     */
    private $standingViewGraph;

    /**
     * @var StandingColumnScope|null
     */
    private $standingColumnScope;

    /**
     * @var StandingColumnGroup|null
     */
    private $standingColumnGroup;

    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->standingViewGraph = new ArrayCollection();
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
     * @param int $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * Get code.
     *
     * @return string
     */
    public function getCode()
    {
        return $this->code;
    }

    /**
     * Set code.
     *
     * @param string $code
     *
     * @return StandingColumn
     */
    public function setCode($code)
    {
        $this->code = $code;

        return $this;
    }

    /**
     * Get name.
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set name.
     *
     * @param string $name
     *
     * @return StandingColumn
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return Collection|StandingViewGraph
     */
    public function getStandingViewGraph()
    {
        return $this->standingViewGraph;
    }

    /**
     * @param Collection|StandingViewGraph $standingViewGraph
     *
     * @return $this
     */
    public function setStandingViewGraph($standingViewGraph)
    {
        $this->standingViewGraph = $standingViewGraph;

        return $this;
    }

    /**
     * Set standingColumnScope.
     *
     * @param StandingColumnScope|null $standingColumnScope
     *
     * @return StandingColumn
     */
    public function setStandingColumnScope(
        StandingColumnScope $standingColumnScope = null
    ) {
        $this->standingColumnScope = $standingColumnScope;

        return $this;
    }

    /**
     * Get standingColumnScope.
     *
     * @return StandingColumnScope|null
     */
    public function getStandingColumnScope()
    {
        return $this->standingColumnScope;
    }

    /**
     * Set standingColumnGroup.
     *
     * @param StandingColumnGroup|null $standingColumnGroup
     *
     * @return StandingColumn
     */
    public function setStandingColumnGroup(
        StandingColumnGroup $standingColumnGroup = null
    ) {
        $this->standingColumnGroup = $standingColumnGroup;

        return $this;
    }

    /**
     * Get standingColumnGroup.
     *
     * @return StandingColumnGroup|null
     */
    public function getStandingColumnGroup()
    {
        return $this->standingColumnGroup;
    }

    /**
     * Add standingViewGraph.
     *
     * @param StandingViewGraph $standingViewGraph
     *
     * @return StandingColumn
     */
    public function addStandingViewGraph(StandingViewGraph $standingViewGraph)
    {
        $this->standingViewGraph[] = $standingViewGraph;

        return $this;
    }

    /**
     * Remove standingViewGraph.
     *
     * @param StandingViewGraph $standingViewGraph
     */
    public function removeStandingViewGraph(
        StandingViewGraph $standingViewGraph
    ) {
        $this->standingViewGraph->removeElement($standingViewGraph);
    }
}
