<?php

namespace Visca\Bundle\LicomBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Visca\Bundle\CoreBundle\Entity\Traits\OptionalDateTimeTrait;
use Visca\Bundle\CoreBundle\Entity\Traits\DeletableTrait;
use Visca\Bundle\LicomBundle\Factory\CompetitionStageFactory;
use Doctrine\Common\Collections\Collection;

/**
 * CompetitionStage.
 */
class CompetitionStage
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
    private $name;

    /**
     * @var Competition
     */
    private $competition;

    /**
     * @var CompetitionStageType|null
     */
    private $competitionStageType1;

    /**
     * @var CompetitionStageType|null
     */
    private $competitionStageType2;

    /**
     * @var Collection
     */
    private $competitionSeasonStage;

    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->competitionSeasonStage = new ArrayCollection();
    }

    /**
     * @return CompetitionStage
     */
    public static function create()
    {
        $factory = new CompetitionStageFactory();

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
     * @return CompetitionStage
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
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
     * @return $this
     */
    public function setCompetition(Competition $competition)
    {
        $this->competition = $competition;

        return $this;
    }

    /**
     * Add competitionSeasonStage.
     *
     * @param CompetitionSeasonStage $competitionSeasonStage
     *
     * @return CompetitionStage
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
     * @return CompetitionStageType|null
     */
    public function getCompetitionStageType1()
    {
        return $this->competitionStageType1;
    }

    /**
     * @param CompetitionStageType|null $competitionStageType1
     *
     * @return CompetitionStage
     */
    public function setCompetitionStageType1(
        CompetitionStageType $competitionStageType1 = null
    ) {
        $this->competitionStageType1 = $competitionStageType1;

        return $this;
    }

    /**
     * @return CompetitionStageType|null
     */
    public function getCompetitionStageType2()
    {
        return $this->competitionStageType2;
    }

    /**
     * @param CompetitionStageType|null $competitionStageType2
     *
     * @return CompetitionStage
     */
    public function setCompetitionStageType2(
        CompetitionStageType $competitionStageType2 = null
    ) {
        $this->competitionStageType2 = $competitionStageType2;

        return $this;
    }
}
