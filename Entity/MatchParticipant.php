<?php

namespace Visca\Bundle\LicomBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Visca\Bundle\CoreBundle\Entity\Traits\OptionalDateTimeTrait;
use Visca\Bundle\CoreBundle\Entity\Traits\DeletableTrait;
use Visca\Bundle\LicomBundle\Entity\Traits\MatchResultByKeyTrait;
use Visca\Bundle\LicomBundle\Factory\MatchParticipantFactory;

/**
 * MatchParticipant.
 *
 * This model describe the Participant playing inside a given Match.
 *
 * Quantity of data: The number of Match is already large, and we have at least 2 Participants per Match.
 * This model usually contains a LARGE amount of rows.
 *
 * @example Team 1 of Match 1, FC Barcelona
 * @example Team 2 of Match 2, Real Madrid
 */
class MatchParticipant
{
    use OptionalDateTimeTrait;
    use DeletableTrait;
    use MatchResultByKeyTrait;

    const HOME = 1;
    const AWAY = 2;

    /**
     * @var int
     */
    private $id;

    /**
     * @var int
     */
    private $number;

    /**
     * @var Match
     */
    private $match;

    /**
     * @var Participant
     */
    private $participant;

    /**
     * @var Collection|MatchResult[]
     */
    private $matchResult;

    /**
     * @var Collection|MatchIncident[]
     */
    private $matchIncident;

    /**
     * @var Collection|MatchParticipantAux[]
     */
    private $matchParticipantAux;

    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->matchResult = new ArrayCollection();
        $this->matchIncident = new ArrayCollection();
        $this->matchParticipantAux = new ArrayCollection();
    }

    /**
     * @return MatchParticipant
     */
    public static function create()
    {
        $factory = new MatchParticipantFactory();

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
     * Get number.
     *
     * @return int
     */
    public function getNumber()
    {
        return $this->number;
    }

    /**
     * Set number.
     *
     * @param int $number
     *
     * @return MatchParticipant
     */
    public function setNumber($number)
    {
        $this->number = $number;

        return $this;
    }

    /**
     * Get match.
     *
     * @return Match
     */
    public function getMatch()
    {
        return $this->match;
    }

    /**
     * Set match.
     *
     * @param Match $match
     *
     * @return MatchParticipant
     */
    public function setMatch(Match $match)
    {
        $this->match = $match;

        return $this;
    }

    /**
     * Get participant.
     *
     * @return Participant
     */
    public function getParticipant()
    {
        return $this->participant;
    }

    /**
     * Set participant.
     *
     * @param Participant $participant
     *
     * @return MatchParticipant
     */
    public function setParticipant(Participant $participant)
    {
        $this->participant = $participant;

        return $this;
    }

    /**
     * Add matchResult.
     *
     * @param MatchResult $matchResult
     *
     * @return MatchParticipant
     */
    public function addMatchResult(
        MatchResult $matchResult
    ) {
        $this->matchResult[] = $matchResult;

        return $this;
    }

    /**
     * Remove matchResult.
     *
     * @param MatchResult $matchResult
     */
    public function removeMatchResult(MatchResult $matchResult)
    {
        $this->matchResult->removeElement($matchResult);
    }

    /**
     * Get matchResult.
     *
     * @return Collection|MatchResult[]
     */
    public function getMatchResult()
    {
        return $this->matchResult;
    }

    /**
     * Add matchIncident.
     *
     * @param MatchIncident $matchIncident
     *
     * @return MatchParticipant
     */
    public function addMatchIncident(
        MatchIncident $matchIncident
    ) {
        $this->matchIncident[] = $matchIncident;

        return $this;
    }

    /**
     * Remove matchIncident.
     *
     * @param MatchIncident $matchIncident
     */
    public function removeMatchIncident(
        MatchIncident $matchIncident
    ) {
        $this->matchIncident->removeElement($matchIncident);
    }

    /**
     * @param MatchParticipantAux $matchParticipantAux
     * @return $this
     */
    public function addMatchParticipantAux(
        MatchParticipantAux $matchParticipantAux
    ) {
        $this->matchParticipantAux[] = $matchParticipantAux;

        return $this;
    }

    /**
     * @param MatchParticipantAux $matchParticipantAux
     */
    public function removeMatchParticipantAux(MatchParticipantAux $matchParticipantAux)
    {
        $this->matchParticipantAux->removeElement($matchParticipantAux);
    }

    /**
     * Get matchParticipantAux.
     *
     * @return Collection|MatchParticipantAux[]
     */
    public function getMatchParticipantAux()
    {
        return $this->getMatchParticipantAux();
    }

    /**
     * @return bool
     */
    public function hasRedCardIncidents()
    {
        foreach ($this->getMatchIncident() as $matchIncident) {
            if ($matchIncident->getMatchIncidentType()->isRedCard()) {
                return true;
            }
        }

        return false;
    }

    /**
     * Get matchIncident.
     *
     * @return Collection
     */
    public function getMatchIncident()
    {
        return $this->matchIncident;
    }

    /**
     * Using the incidents for this MatchParticipant, this methods
     * will return all his MatchIncident which are Red Card.
     *
     * @return array
     */
    public function getRedCardIncidents()
    {
        $redCardsIncidents = [];
        foreach ($this->getMatchIncident() as $matchIncident) {
            if (!$matchIncident->getMatchIncidentType()->isRedCard()) {
                continue;
            }
            $redCardsIncidents[] = $matchIncident;
        }

        return $redCardsIncidents;
    }
}
