<?php

namespace Visca\Bundle\LicomBundle\Entity;

use Visca\Bundle\CoreBundle\Entity\Traits\DeletableTrait;

/**
 * CompetitionSeasonStageGraph.
 */
class CompetitionSeasonStageGraph
{
    use DeletableTrait;

    /**
     * @var CompetitionSeasonStageGraphLabel
     */
    private $label;

    /**
     * @var CompetitionRound
     */
    private $competitionRound;

    /**
     * @var CompetitionSeasonStage
     */
    private $competitionSeasonStage;

    /**
     * Get label.
     *
     * @return CompetitionSeasonStageGraphLabel
     */
    public function getLabel()
    {
        return $this->label;
    }

    /**
     * Set label.
     *
     * @param CompetitionSeasonStageGraphLabel $label
     *
     * @return CompetitionSeasonStageGraph
     */
    public function setLabel(CompetitionSeasonStageGraphLabel $label)
    {
        $this->label = $label;

        return $this;
    }

    /**
     * Get competitionRound.
     *
     * @return CompetitionRound
     */
    public function getCompetitionRound()
    {
        return $this->competitionRound;
    }

    /**
     * Set competitionRound.
     *
     * @param CompetitionRound $competitionRound
     *
     * @return CompetitionSeasonStageGraph
     */
    public function setCompetitionRound(CompetitionRound $competitionRound)
    {
        $this->competitionRound = $competitionRound;

        return $this;
    }

    /**
     * Get CompetitionSeasonStage.
     *
     * @return CompetitionSeasonStage
     */
    public function getCompetitionSeasonStage()
    {
        return $this->competitionSeasonStage;
    }

    /**
     * Set CompetitionSeasonStage.
     *
     * @param CompetitionSeasonStage $competitionSeasonStage
     *
     * @return CompetitionSeasonStageGraph
     */
    public function setCompetitionSeasonStage(
        CompetitionSeasonStage $competitionSeasonStage
    ) {
        $this->competitionSeasonStage = $competitionSeasonStage;

        return $this;
    }
}
