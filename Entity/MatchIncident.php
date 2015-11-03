<?php

namespace Visca\Bundle\LicomBundle\Entity;

use DateTime;
use Visca\Bundle\CoreBundle\Entity\Traits\OptionalDateTimeTrait;
use Visca\Bundle\CoreBundle\Entity\Traits\DeletableTrait;
use Visca\Bundle\LicomBundle\Entity\Interfaces\EntityWithAuxInterface;
use Visca\Bundle\LicomBundle\Entity\Traits\EntityWithAuxTrait;
use Visca\Bundle\LicomBundle\Factory\MatchIncidentFactory;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

/**
 * MatchIncident.
 *
 * Describe all the incidents related of a given Match.
 * This model does NOT contains the comments related to the match but only the incidents,
 * no mixed must be made between MatchIncident and MatchComment.
 *
 * Quantity of data: The number of Match is already large, so the number of incidents is even bigger.
 * This model usually contains a LARGE amount of rows.
 *
 * Why is the relationship with Participant optional?
 * The incidents have a relationship with the Match and can describe anything happening during the match.
 * If the incident is related to a Participant (a yellow card, a goal, etc..) this field will be filled in.
 * If not, it will be empty.
 *
 * NOTE: It can happen that the incident is a card, a goal, etc.. but Participant
 * is still NULL. This happen when the provider have sent the incident by providing
 * the player's name, but did not make the relationship to the participant model in database.
 * They do this to provide the goal faster and will fix this mistake a couple of seconds later.
 *
 * @example Red Card of Ronaldo, 37'
 * @example Goal of Messi, 38'
 */
class MatchIncident implements EntityWithAuxInterface
{
    use OptionalDateTimeTrait;
    use DeletableTrait;
    use EntityWithAuxTrait;

    /**
     * @var int
     */
    private $id;

    /**
     * @var int
     */
    private $timeElapsed;

    /**
     * @var int
     */
    private $timeElapsedExtra;

    /**
     * @var int|null
     */
    private $position;

    /**
     * @var DateTime
     */
    private $time;

    /**
     * @var MatchParticipant
     */
    private $matchParticipant;

    /**
     * @var MatchIncidentType
     */
    private $matchIncidentType;

    /**
     * @var Participant|null
     */
    private $participant;

    /**
     * @var Collection
     */
    private $matchIncidentAux;

    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->matchIncidentAux = new ArrayCollection();
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
     * Get timeElapsed.
     *
     * @return int
     */
    public function getTimeElapsed()
    {
        return $this->timeElapsed;
    }

    /**
     * Set timeElapsed.
     *
     * @param int $timeElapsed
     *
     * @return MatchIncident
     */
    public function setTimeElapsed($timeElapsed)
    {
        $this->timeElapsed = $timeElapsed;

        return $this;
    }

    /**
     * Get timeElapsedExtra.
     *
     * @return int
     */
    public function getTimeElapsedExtra()
    {
        return $this->timeElapsedExtra;
    }

    /**
     * Set timeElapsedExtra.
     *
     * @param int $timeElapsedExtra
     *
     * @return MatchIncident
     */
    public function setTimeElapsedExtra($timeElapsedExtra)
    {
        $this->timeElapsedExtra = $timeElapsedExtra;

        return $this;
    }

    /**
     * Get position.
     *
     * @return int|null
     */
    public function getPosition()
    {
        return $this->position;
    }

    /**
     * Set position.
     *
     * @param int|null $position
     *
     * @return MatchIncident
     */
    public function setPosition($position)
    {
        $this->position = $position;

        return $this;
    }

    /**
     * Get time.
     *
     * @return DateTime
     */
    public function getTime()
    {
        return $this->time;
    }

    /**
     * Set time.
     *
     * @param DateTime $time
     *
     * @return MatchIncident
     */
    public function setTime($time)
    {
        $this->time = $time;

        return $this;
    }

    /**
     * Get matchParticipant.
     *
     * @return MatchParticipant
     */
    public function getMatchParticipant()
    {
        return $this->matchParticipant;
    }

    /**
     * Set matchParticipant.
     *
     * @param MatchParticipant $matchParticipant
     *
     * @return MatchIncident
     */
    public function setMatchParticipant(
        MatchParticipant $matchParticipant
    ) {
        $this->matchParticipant = $matchParticipant;

        return $this;
    }

    /**
     * Get matchIncidentType.
     *
     * @return MatchIncidentType
     */
    public function getMatchIncidentType()
    {
        return $this->matchIncidentType;
    }

    /**
     * Set matchIncidentType.
     *
     * @param MatchIncidentType $matchIncidentType
     *
     * @return MatchIncident
     */
    public function setMatchIncidentType(
        MatchIncidentType $matchIncidentType
    ) {
        $this->matchIncidentType = $matchIncidentType;

        return $this;
    }

    /**
     * Get participant.
     *
     * @return Participant|null
     */
    public function getParticipant()
    {
        return $this->participant;
    }

    /**
     * Set participant.
     *
     * @param Participant|null $participant
     *
     * @return MatchIncident
     */
    public function setParticipant(
        Participant $participant = null
    ) {
        $this->participant = $participant;

        return $this;
    }

    /**
     * @return Match
     */
    public static function create()
    {
        $factory = new MatchIncidentFactory();

        return $factory->create();
    }

    /**
     * Add matchIncidentAux.
     *
     * @param MatchIncidentAux $matchIncidentAux
     *
     * @return MatchIncident
     */
    public function addMatchIncidentAux(MatchIncidentAux $matchIncidentAux)
    {
        $this->matchIncidentAux[] = $matchIncidentAux;

        return $this;
    }

    /**
     * Remove matchIncidentAux.
     *
     * @param MatchIncidentAux $matchIncidentAux
     */
    public function removeMatchIncidentAux(MatchIncidentAux $matchIncidentAux)
    {
        $this->matchIncidentAux->removeElement($matchIncidentAux);
    }

    /**
     * Get matchIncidentAux.
     *
     * @return Collection
     */
    public function getMatchIncidentAux()
    {
        return $this->matchIncidentAux;
    }

    /**
     * Get auxiliar values.
     *
     * @return ArrayCollection|Collection
     */
    public function getAux()
    {
        return $this->matchIncidentAux;
    }
}
