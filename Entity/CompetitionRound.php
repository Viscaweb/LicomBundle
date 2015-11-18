<?php

namespace Visca\Bundle\LicomBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Visca\Bundle\CoreBundle\Entity\Traits\OptionalDateTimeTrait;
use Visca\Bundle\CoreBundle\Entity\Traits\DeletableTrait;
use Visca\Bundle\LicomBundle\Entity\Traits\OptionalPeriodTrait;
use Visca\Bundle\LicomBundle\Entity\Traits\ToStringNameAndIdTrait;

/**
 * CompetitionRound.
 */
class CompetitionRound
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
    private $competitionLeg;

    /**
     * @var CompetitionSeasonStage
     */
    private $competitionSeasonStage;

    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->competitionLeg = new ArrayCollection();
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
     * @return CompetitionRound
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Add competitionLeg.
     *
     * @param CompetitionLeg $competitionLeg
     *
     * @return CompetitionRound
     */
    public function addCompetitionLeg(CompetitionLeg $competitionLeg)
    {
        $this->competitionLeg[] = $competitionLeg;

        return $this;
    }

    /**
     * Remove competitionLeg.
     *
     * @param CompetitionLeg $competitionLeg
     */
    public function removeCompetitionLeg(CompetitionLeg $competitionLeg)
    {
        $this->competitionLeg->removeElement($competitionLeg);
    }

    /**
     * Get competitionLeg.
     *
     * @return Collection
     */
    public function getCompetitionLeg()
    {
        return $this->competitionLeg;
    }

    /**
     * Get competitionSeasonStage.
     *
     * @return CompetitionSeasonStage
     */
    public function getCompetitionSeasonStage()
    {
        return $this->competitionSeasonStage;
    }

    /**
     * Set competitionSeasonStage.
     *
     * @param CompetitionSeasonStage $competitionSeasonStage
     *
     * @return CompetitionRound
     */
    public function setCompetitionSeasonStage(
        CompetitionSeasonStage $competitionSeasonStage
    ) {
        $this->competitionSeasonStage = $competitionSeasonStage;

        return $this;
    }
}
