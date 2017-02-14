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
     * @var Collection
     */
    private $matchLineupParticipants;

    /**
     * @var string|null
     */
    private $formation;

    public function __construct()
    {
        $this->matchLineupParticipants = new \Doctrine\Common\Collections\ArrayCollection();
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

    /**
     * @return bool
     */
    public function hasFormation()
    {
        return !empty($this->formation);
    }

    /**
     * @param MatchLineupParticipant $matchLineupParticipant
     *
     * @return $this
     */
    public function addMatchLineupParticipant(MatchLineupParticipant $matchLineupParticipant)
    {
        $this->matchLineupParticipants[] = $matchLineupParticipant;

        return $this;
    }

    /**
     * @param MatchLineupParticipant $matchLineupParticipant
     *
     * @return $this
     */
    public function removeMatchLineupParticipant(MatchLineupParticipant $matchLineupParticipant)
    {
        $this->matchLineupParticipants->removeElement($matchLineupParticipant);

        return $this;
    }

    /**
     * @return Collection
     */
    public function getMatchLineupParticipants()
    {
        return $this->matchLineupParticipants;
    }

    /**
     * @return bool
     */
    public function hasMatchLineupParticipants()
    {
        return count($this->matchLineupParticipants) > 0;
    }

    /**
     * @param MatchLineupParticipant[] $matchLineupParticipants
     *
     * @return MatchLineup
     */
    public function setMatchLineupParticipants($matchLineupParticipants)
    {
        $this->matchLineupParticipants = $matchLineupParticipants;

        return $this;
    }
}
