<?php

namespace Visca\Bundle\LicomBundle\Entity;

use Visca\Bundle\CoreBundle\Entity\Traits\DeletableTrait;

/**
 * Class CompetitionRoundGraph.
 */
class CompetitionRoundGraph
{
    use DeletableTrait;

    /**
     * @var CompetitionLeg
     */
    private $competitionLeg;

    /**
     * @var CompetitionRound
     */
    private $competitionRound;

    /**
     * @var CompetitionRoundGraphLabel
     */
    private $label;

    /**
     * Get competitionLeg.
     *
     * @return CompetitionLeg
     */
    public function getCompetitionLeg()
    {
        return $this->competitionLeg;
    }

    /**
     * Set competitionLeg.
     *
     * @param CompetitionLeg $competitionLeg
     *
     * @return CompetitionRoundGraph
     */
    public function setCompetitionLeg(CompetitionLeg $competitionLeg = null)
    {
        $this->competitionLeg = $competitionLeg;

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
     * @return CompetitionRoundGraph
     */
    public function setCompetitionRound(CompetitionRound $competitionRound)
    {
        $this->competitionRound = $competitionRound;

        return $this;
    }

    /**
     * Get competitionRoundGraphLabel.
     *
     * @return CompetitionRoundGraphLabel
     */
    public function getLabel()
    {
        return $this->label;
    }

    /**
     * Set competitionRoundGraphLabel.
     *
     * @param CompetitionRoundGraphLabel $label
     *
     * @return CompetitionRoundGraph
     */
    public function setLabel(
        CompetitionRoundGraphLabel $label
    ) {
        $this->label = $label;

        return $this;
    }
}
