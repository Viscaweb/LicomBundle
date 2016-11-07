<?php

namespace Visca\Bundle\LicomBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Visca\Bundle\CoreBundle\Entity\Traits\DeletableTrait;
use Visca\Bundle\CoreBundle\Entity\Traits\OptionalDateTimeTrait;
use Visca\Bundle\LicomBundle\Entity\Traits\ToStringNameAndIdTrait;
use Visca\Bundle\LicomBundle\Factory\CompetitionFactory;

/**
 * Competition.
 *
 * This model is the main model describing the competition tree.
 * There are many relationship and we HIGHLY suggest you to learn them through
 * the Skipper file and not reading the models.
 *
 * Quantity of data: Since all the competitions will be saved in here,
 * this model usually contains a LARGE amount of rows.
 *
 * @example Champions League
 * @example Liga
 * @example NFL
 */
class Competition
{
    use OptionalDateTimeTrait;
    use DeletableTrait;
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
     * @var int|null
     */
    private $level;

    /**
     * @var string
     */
    private $gender;

    /**
     * @var int
     */
    private $orderInsideCategory = 255;

    /**
     * @var Collection|CompetitionSeason[]
     */
    private $competitionSeason;

    /**
     * @var CompetitionCategory
     */
    private $competitionCategory;

    /**
     * @var Collection
     */
    private $competitionGraph;

    /**
     * @var Collection
     */
    private $competitionStage;

    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->competitionSeason = new ArrayCollection();
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
     * @return Competition
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get level.
     *
     * @return int|null
     */
    public function getLevel()
    {
        return $this->level;
    }

    /**
     * Set level.
     *
     * @param int|null $level
     *
     * @return Competition
     */
    public function setLevel($level)
    {
        $this->level = $level;

        return $this;
    }

    /**
     * Get gender.
     *
     * @return string
     */
    public function getGender()
    {
        return $this->gender;
    }

    /**
     * Set gender.
     *
     * @param string $gender
     *
     * @return Competition
     */
    public function setGender($gender)
    {
        $this->gender = $gender;

        return $this;
    }

    /**
     * Get orderInsideCategory.
     *
     * @return int
     */
    public function getOrderInsideCategory()
    {
        return $this->orderInsideCategory;
    }

    /**
     * Set orderInsideCategory.
     *
     * @param int $orderInsideCategory
     *
     * @return Competition
     */
    public function setOrderInsideCategory($orderInsideCategory)
    {
        $this->orderInsideCategory = $orderInsideCategory;

        return $this;
    }

    /**
     * Add competitionSeason.
     *
     * @param CompetitionSeason $competitionSeason
     *
     * @return Competition
     */
    public function addCompetitionSeason(CompetitionSeason $competitionSeason)
    {
        $this->competitionSeason[] = $competitionSeason;

        return $this;
    }

    /**
     * Remove competitionSeason.
     *
     * @param CompetitionSeason $competitionSeason
     */
    public function removeCompetitionSeason(
        CompetitionSeason $competitionSeason
    ) {
        $this->competitionSeason->removeElement($competitionSeason);
    }

    /**
     * Get competitionSeason.
     *
     * @return CompetitionSeason[]
     */
    public function getCompetitionSeason()
    {
        return $this->competitionSeason;
    }

    /**
     * Get competitionCategory.
     *
     * @return CompetitionCategory
     */
    public function getCompetitionCategory()
    {
        return $this->competitionCategory;
    }

    /**
     * Set competitionCategory.
     *
     * @param CompetitionCategory $competitionCategory
     *
     * @return Competition
     */
    public function setCompetitionCategory(
        CompetitionCategory $competitionCategory
    ) {
        $this->competitionCategory = $competitionCategory;

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

    /**
     * Add competitionStage.
     *
     * @param CompetitionStage $competitionStage
     *
     * @return Competition
     */
    public function addCompetitionStage(CompetitionStage $competitionStage)
    {
        $this->competitionStage[] = $competitionStage;

        return $this;
    }

    /**
     * Remove competitionStage.
     *
     * @param CompetitionStage $competitionStage
     */
    public function removeCompetitionStage(CompetitionStage $competitionStage)
    {
        $this->competitionStage->removeElement($competitionStage);
    }

    /**
     * Get competitionStage.
     *
     * @return Collection
     */
    public function getCompetitionStage()
    {
        return $this->competitionStage;
    }

    /**
     * @return Competition
     */
    public static function create()
    {
        $factory = new CompetitionFactory();

        return $factory->create();
    }
}
