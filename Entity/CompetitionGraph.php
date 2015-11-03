<?php

namespace Visca\Bundle\LicomBundle\Entity;

use Visca\Bundle\CoreBundle\Entity\Traits\DeletableTrait;

/**
 * CompetitionGraph.
 */
class CompetitionGraph
{
    use DeletableTrait;

    /**
     * @var CompetitionGraphLabel
     */
    protected $label;

    /**
     * @var Competition
     */
    protected $competition;

    /**
     * @var CompetitionSeason
     */
    protected $competitionSeason;

    /**
     * Get Competition.
     *
     * @return Competition
     */
    public function getCompetition()
    {
        return $this->competition;
    }

    /**
     * Set Competition.
     *
     * @param Competition $competition
     *
     * @return CompetitionGraph
     */
    public function setCompetition(Competition $competition)
    {
        $this->competition = $competition;

        return $this;
    }

    /**
     * Get label.
     *
     * @return CompetitionGraphLabel
     */
    public function getLabel()
    {
        return $this->label;
    }

    /**
     * Set label.
     *
     * @param CompetitionGraphLabel $label
     *
     * @return CompetitionGraph
     */
    public function setLabel(CompetitionGraphLabel $label)
    {
        $this->label = $label;

        return $this;
    }

    /**
     * Get CompetitionSeason.
     *
     * @return CompetitionSeason
     */
    public function getCompetitionSeason()
    {
        return $this->competitionSeason;
    }

    /**
     * Set CompetitionSeason.
     *
     * @param CompetitionSeason $competitionSeason
     *
     * @return $this
     */
    public function setCompetitionSeason(CompetitionSeason $competitionSeason)
    {
        $this->competitionSeason = $competitionSeason;

        return $this;
    }
}
