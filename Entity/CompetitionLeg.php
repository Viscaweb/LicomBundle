<?php

namespace Visca\Bundle\LicomBundle\Entity;

use Visca\Bundle\CoreBundle\Entity\Traits\OptionalDateTimeTrait;
use Visca\Bundle\CoreBundle\Entity\Traits\DeletableTrait;
use Visca\Bundle\LicomBundle\Entity\Traits\OptionalPeriodTrait;

/**
 * CompetitionLeg.
 */
class CompetitionLeg
{
    use OptionalDateTimeTrait;
    use DeletableTrait;
    use OptionalPeriodTrait;

    /**
     * @var int
     */
    private $id;

    /**
     * @var string
     */
    private $name;

    /**
     * @var CompetitionRound
     */
    private $competitionRound;

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
     * @return CompetitionLeg
     */
    public function setName($name)
    {
        $this->name = $name;

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
     * @return CompetitionLeg
     */
    public function setCompetitionRound(CompetitionRound $competitionRound)
    {
        $this->competitionRound = $competitionRound;

        return $this;
    }
}
