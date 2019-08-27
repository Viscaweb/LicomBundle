<?php

namespace Visca\Bundle\LicomBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Visca\Bundle\CoreBundle\Entity\Traits\DeletableTrait;
use Visca\Bundle\CoreBundle\Entity\Traits\OptionalDateTimeTrait;
use Visca\Bundle\LicomBundle\Entity\Interfaces\EntityWithAuxInterface;
use Visca\Bundle\LicomBundle\Entity\MatchIncident\Interfaces\MatchIncidentAuthorInterface;
use Visca\Bundle\LicomBundle\Entity\Traits\EntityWithAuxTrait;

/**
 * Participant.
 *
 * This model contains all the Participant needed in the project:
 * the teams
 * the players
 * etc..
 *
 * It arrives that the same physical person is two times in this model when, for example,
 * a trainer was in his previous career a player (Pep Guardiola).
 *
 * Since all the participants (teams, players, etc.) will be saved in here,
 * this model usually contains a LARGE amount of rows.
 */
abstract class Participant implements EntityWithAuxInterface, MatchIncidentAuthorInterface
{
    use OptionalDateTimeTrait;
    use DeletableTrait;
    use EntityWithAuxTrait;

    /**
     * @var int
     */
    protected $id;

    /**
     * @var string
     */
    protected $name;

    /**
     * @var string
     */
    protected $gender;

    /**
     * @var Country
     */
    protected $country;

    /**
     * @var Sport
     */
    protected $sport;

    /**
     * @var bool
     */
    protected $toBeConfirmed;

    /**
     * @var string
     */
    protected $type;

    /**
     * @var Collection
     */
    protected $matchParticipant;

    /**
     * @var Collection
     */
    protected $aux;

    /**
     * @var Collection
     */
    protected $matchIncident;

    /**
     * @var Collection
     */
    protected $participantMembership;

    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->matchParticipant = new ArrayCollection();
        $this->aux = new ArrayCollection();
        $this->matchIncident = new ArrayCollection();
        $this->participantMembership = new ArrayCollection();
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
     * @return Participant
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get gender.
     *
     * @return string
     */
    public function getGender()
    {
        return $this->gender;
    }

    /**
     * Set gender.
     *
     * @param string $gender
     *
     * @return Participant
     */
    public function setGender($gender)
    {
        $this->gender = $gender;

        return $this;
    }

    /**
     * Get Country.
     *
     * @return Country
     */
    public function getCountry()
    {
        return $this->country;
    }

    /**
     * Set country.
     *
     * @param Country $country
     *
     * @return Participant
     */
    public function setCountry(Country $country)
    {
        $this->country = $country;

        return $this;
    }

    /**
     * Get sport.
     *
     * @return Sport
     */
    public function getSport()
    {
        return $this->sport;
    }

    /**
     * Set sport.
     *
     * @param Sport $sport
     *
     * @return Participant
     */
    public function setSport(Sport $sport)
    {
        $this->sport = $sport;

        return $this;
    }

    /**
     * Get toBeConfirmed.
     *
     * @return bool
     */
    public function getToBeConfirmed()
    {
        return $this->toBeConfirmed;
    }

    /**
     * Set toBeConfirmed.
     *
     * @param bool $toBeConfirmed
     *
     * @return Participant
     */
    public function setToBeConfirmed($toBeConfirmed)
    {
        $this->toBeConfirmed = $toBeConfirmed;

        return $this;
    }

    /**
     * Get type.
     *
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Set type.
     *
     * @param string $type
     *
     * @return Participant
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Add matchParticipant.
     *
     * @param MatchParticipant $matchParticipant
     *
     * @return Participant
     */
    public function addMatchParticipant(
        MatchParticipant $matchParticipant
    ) {
        $this->matchParticipant[] = $matchParticipant;

        return $this;
    }

    /**
     * Remove matchParticipant.
     *
     * @param MatchParticipant $matchParticipant
     */
    public function removeMatchParticipant(
        MatchParticipant $matchParticipant
    ) {
        $this->matchParticipant->removeElement($matchParticipant);
    }

    /**
     * Get matchParticipant.
     *
     * @return Collection
     */
    public function getMatchParticipant()
    {
        return $this->matchParticipant;
    }

    /**
     * Get participantAux.
     *
     * @return Collection
     */
    public function getAux()
    {
        return $this->aux;
    }

    /**
     * Add Aux.
     *
     * @param ParticipantAux $participantAux
     *
     * @return Participant
     */
    public function addAux(
        ParticipantAux $participantAux
    ) {
        $this->aux[] = $participantAux;

        return $this;
    }

    /**
     * Remove Aux.
     *
     * @param ParticipantAux $participantAux
     */
    public function removeAux(
        ParticipantAux $participantAux
    ) {
        $this->aux->removeElement($participantAux);
    }

    /**
     * Get matchIncident[].
     *
     * @return MatchIncident[]
     */
    public function getMatchIncident()
    {
        return $this->matchIncident;
    }

    /**
     * Add matchIncident.
     *
     * @param MatchIncident $matchIncident
     *
     * @return Participant
     */
    public function addMatchIncident(MatchIncident $matchIncident)
    {
        $this->matchIncident[] = $matchIncident;

        return $this;
    }

    /**
     * Remove matchIncident.
     *
     * @param MatchIncident $matchIncident
     */
    public function removeMatchIncident(MatchIncident $matchIncident)
    {
        $this->matchIncident->removeElement($matchIncident);
    }

    /**
     * @return Collection
     */
    public function getParticipantMembership()
    {
        return $this->participantMembership;
    }

    public function addParticipantMembership(ParticipantMembership $participantMembership)
    {
        $this->participantMembership->add($participantMembership);
    }

    public function removeParticipantMembership(ParticipantMembership $participantMembership)
    {
        $this->participantMembership->removeElement($participantMembership);
    }
}
