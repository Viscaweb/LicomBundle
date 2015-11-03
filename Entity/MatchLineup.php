<?php

namespace Visca\Bundle\LicomBundle\Entity;

use Visca\Bundle\CoreBundle\Entity\Traits\OptionalDateTimeTrait;
use Visca\Bundle\CoreBundle\Entity\Traits\DeletableTrait;

/**
 * MatchLineup.
 *
 * This model describe the lineups and formations related to a given MatchParticipant.
 */
class MatchLineup
{
    use OptionalDateTimeTrait;
    use DeletableTrait;

    /**
     * @var int
     */
    private $id;

    /**
     * @var MatchParticipant
     */
    private $matchParticipant;

    /**
     * @var string|null
     */
    private $formation;

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
     * Get MatchParticipant.
     *
     * @return MatchParticipant
     */
    public function getMatchParticipant()
    {
        return $this->matchParticipant;
    }

    /**
     * Set MatchParticipant.
     *
     * @param MatchParticipant $matchParticipant
     *
     * @return MatchLineup
     */
    public function setMatchParticipant(MatchParticipant $matchParticipant)
    {
        $this->matchParticipant = $matchParticipant;

        return $this;
    }

    /**
     * Get formation.
     *
     * @return string|null
     */
    public function getFormation()
    {
        return $this->formation;
    }

    /**
     * Set formation.
     *
     * @param string|null $formation
     *
     * @return MatchLineup
     */
    public function setFormation($formation)
    {
        $this->formation = $formation;

        return $this;
    }
}
