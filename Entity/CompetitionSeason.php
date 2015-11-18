<?php

namespace Visca\Bundle\LicomBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Visca\Bundle\CoreBundle\Entity\Traits\OptionalDateTimeTrait;
use Visca\Bundle\CoreBundle\Entity\Traits\DeletableTrait;
use Visca\Bundle\LicomBundle\Entity\Traits\OptionalPeriodTrait;
use Visca\Bundle\LicomBundle\Entity\Traits\ToStringNameAndIdTrait;
use Visca\Bundle\LicomBundle\Factory\CompetitionSeasonFactory;

/**
 * CompetitionSeason.
 */
class CompetitionSeason
{
    use OptionalDateTimeTrait;
    use DeletableTrait;
    use OptionalPeriodTrait;
    use ToStringNameAndIdTrait;

    /**
     * @var int
     */
    private $id;

    /**
     * @var string
     */
    private $name;

    /**
     * @var Collection
     */
    private $competitionSeasonStage;

    /**
     * @var Competition
     */
    private $competition;

    /**
     * @var Collection
     */
    private $competitionGraph;

    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->competitionSeasonStage = new ArrayCollection();
    }

    /**
     * @return CompetitionSeason
     */
    public static function create()
    {
        $factory = new CompetitionSeasonFactory();

        return $factory->create();
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
     * @return CompetitionSeason
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Add competitionSeasonStage.
     *
     * @param CompetitionSeasonStage $competitionSeasonStage
     *
     * @return CompetitionSeason
     */
    public function addCompetitionSeasonStage(
        CompetitionSeasonStage $competitionSeasonStage
    ) {
        $this->competitionSeasonStage[] = $competitionSeasonStage;

        return $this;
    }

    /**
     * Remove competitionSeasonStage.
     *
     * @param CompetitionSeasonStage $competitionSeasonStage
     */
    public function removeCompetitionSeasonStage(
        CompetitionSeasonStage $competitionSeasonStage
    ) {
        $this->competitionSeasonStage->removeElement($competitionSeasonStage);
    }

    /**
     * Get competitionSeasonStage.
     *
     * @return Collection
     */
    public function getCompetitionSeasonStage()
    {
        return $this->competitionSeasonStage;
    }

    /**
     * Get competition.
     *
     * @return Competition
     */
    public function getCompetition()
    {
        return $this->competition;
    }

    /**
     * Set competition.
     *
     * @param Competition $competition
     *
     * @return CompetitionSeason
     */
    public function setCompetition(Competition $competition)
    {
        $this->competition = $competition;

        return $this;
    }

    /**
     * Add competitionGraph.
     *
     * @param CompetitionGraph $competitionGraph
     *
     * @return Competition
     */
    public function addCompetitionGraph(CompetitionGraph $competitionGraph)
    {
        $this->competitionGraph[] = $competitionGraph;

        return $this;
    }

    /**
     * Remove competitionGraph.
     *
     * @param CompetitionGraph $competitionGraph
     */
    public function removeCompetitionGraph(CompetitionGraph $competitionGraph)
    {
        $this->competitionGraph->removeElement($competitionGraph);
    }

    /**
     * Get competitionGraph.
     *
     * @return Collection
     */
    public function getCompetitionGraph()
    {
        return $this->competitionGraph;
    }
}
