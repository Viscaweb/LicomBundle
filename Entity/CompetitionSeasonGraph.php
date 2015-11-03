<?php

namespace Visca\Bundle\LicomBundle\Entity;

use Visca\Bundle\CoreBundle\Entity\Traits\DeletableTrait;

/**
 * CompetitionSeasonGraph.
 */
class CompetitionSeasonGraph
{
    use DeletableTrait;

    /**
     * @var CompetitionSeasonGraphLabel
     */
    private $label;

    /**
     * @var int
     */
    private $competitionSeason;

    /**
     * @var int
     */
    private $competitionStageType;

    /**
     * Get label.
     *
     * @return CompetitionSeasonGraphLabel
     */
    public function getLabel()
    {
        return $this->label;
    }

    /**
     * Set label.
     *
     * @param CompetitionSeasonGraphLabel $label
     *
     * @return CompetitionSeasonGraph
     */
    public function setLabel(CompetitionSeasonGraphLabel $label)
    {
        $this->label = $label;

        return $this;
    }

    /**
     * Get competitionSeason.
     *
     * @return int
     */
    public function getCompetitionSeason()
    {
        return $this->competitionSeason;
    }

    /**
     * Set competitionSeason.
     *
     * @param int $competitionSeason
     *
     * @return CompetitionSeasonGraph
     */
    public function setCompetitionSeason($competitionSeason)
    {
        $this->competitionSeason = $competitionSeason;

        return $this;
    }

    /**
     * Get competitionStageType.
     *
     * @return int
     */
    public function getCompetitionStageType()
    {
        return $this->competitionStageType;
    }

    /**
     * Set competitionStageType.
     *
     * @param int $competitionStageType
     *
     * @return CompetitionSeasonGraph
     */
    public function setCompetitionStageType($competitionStageType)
    {
        $this->competitionStageType = $competitionStageType;

        return $this;
    }
}
