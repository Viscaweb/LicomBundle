<?php

namespace Visca\Bundle\LicomBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Visca\Bundle\CoreBundle\Entity\Traits\DeletableTrait;
use Visca\Bundle\CoreBundle\Entity\Traits\OptionalDateTimeTrait;
use Visca\Bundle\LicomBundle\Entity\Traits\OptionalPeriodTrait;
use Visca\Bundle\LicomBundle\Factory\CompetitionSeasonStageFactory;

/**
 * CompetitionSeasonStage.
 */
class CompetitionSeasonStage
{
    use OptionalDateTimeTrait;
    use DeletableTrait;
    use OptionalPeriodTrait;

    /**
     * @var int
     */
    private $id;

    /**
     * @var Collection
     */
    private $match;

    /**
     * @var Collection
     */
    private $competitionRound;

    /**
     * @var CompetitionSeason
     */
    private $competitionSeason;

    /**
     * @var CompetitionStage
     */
    private $competitionStage;

    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->match = new ArrayCollection();
        $this->competitionRound = new ArrayCollection();
    }

    /**
     * @return CompetitionSeasonStage
     */
    public static function create()
    {
        $factory = new CompetitionSeasonStageFactory();

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

    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Add match.
     *
     * @param Match $match
     *
     * @return CompetitionSeasonStage
     */
    public function addMatch(Match $match)
    {
        $this->match[] = $match;

        return $this;
    }

    /**
     * Remove match.
     *
     * @param Match $match
     */
    public function removeMatch(Match $match)
    {
        $this->match->removeElement($match);
    }

    /**
     * Get match.
     *
     * @return Collection
     */
    public function getMatch()
    {
        return $this->match;
    }

    /**
     * Add competitionRound.
     *
     * @param CompetitionRound $competitionRound
     *
     * @return CompetitionSeasonStage
     */
    public function addCompetitionRound(CompetitionRound $competitionRound)
    {
        $this->competitionRound[] = $competitionRound;

        return $this;
    }

    /**
     * Remove competitionRound.
     *
     * @param CompetitionRound $competitionRound
     */
    public function removeCompetitionRound(CompetitionRound $competitionRound)
    {
        $this->competitionRound->removeElement($competitionRound);
    }

    /**
     * Get competitionRound.
     *
     * @return Collection
     */
    public function getCompetitionRound()
    {
        return $this->competitionRound;
    }

    /**
     * Get competitionSeason.
     *
     * @return CompetitionSeason
     */
    public function getCompetitionSeason()
    {
        return $this->competitionSeason;
    }

    /**
     * Set competitionSeason.
     *
     * @param CompetitionSeason $competitionSeason
     *
     * @return CompetitionSeasonStage
     */
    public function setCompetitionSeason(CompetitionSeason $competitionSeason)
    {
        $this->competitionSeason = $competitionSeason;

        return $this;
    }

    /**
     * Get competitionStage.
     *
     * @return CompetitionStage
     */
    public function getCompetitionStage()
    {
        return $this->competitionStage;
    }

    /**
     * Set competitionStage.
     *
     * @param CompetitionStage $competitionStage
     *
     * @return CompetitionSeasonStage
     */
    public function setCompetitionStage(CompetitionStage $competitionStage)
    {
        $this->competitionStage = $competitionStage;

        return $this;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return sprintf(
            '%s %s (%s)',
            $this->getCompetitionStage()->getName(),
            $this->getCompetitionSeason()->getName(),
            $this->getId()
        );
    }
}
