<?php

namespace Visca\Bundle\LicomBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Visca\Bundle\CoreBundle\Entity\Traits\DeletableTrait;
use Visca\Bundle\CoreBundle\Entity\Traits\OptionalDateTimeTrait;
use Visca\Bundle\LicomBundle\Factory\StandingRowFactory;

/**
 * StandingRow.
 *
 * This model contains the rows to display when constructing a given type of standing.
 * To get more information about this model and how it operates, take a look on the Standing model.
 */
class StandingRow
{
    use OptionalDateTimeTrait;
    use DeletableTrait;

    /**
     * @var int
     */
    private $id;

    /**
     * @var Standing
     */
    private $standing;

    /**
     * @var Participant
     */
    private $participant;

    /**
     * @var StandingPromotion|null
     */
    private $standingPromotion;

    /**
     * @var Collection|StandingCell[]
     */
    private $standingCell;

    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->standingCell = new ArrayCollection();
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
     * Get Standing.
     *
     * @return Standing
     */
    public function getStanding()
    {
        return $this->standing;
    }

    /**
     * Set Standing.
     *
     * @param Standing $standing
     *
     * @return StandingRow
     */
    public function setStanding(Standing $standing)
    {
        $this->standing = $standing;

        return $this;
    }

    /**
     * Get Participant.
     *
     * @return Participant
     */
    public function getParticipant()
    {
        return $this->participant;
    }

    /**
     * Set Participant.
     *
     * @param Participant $participant
     *
     * @return StandingRow
     */
    public function setParticipant(Participant $participant)
    {
        $this->participant = $participant;

        return $this;
    }

    /**
     * Get StandingPromotion.
     *
     * @return StandingPromotion|null
     */
    public function getStandingPromotion()
    {
        return $this->standingPromotion;
    }

    /**
     * Set StandingPromotion.
     *
     * @param StandingPromotion|null $standingPromotion
     *
     * @return StandingRow
     */
    public function setStandingPromotion(
        StandingPromotion $standingPromotion = null
    ) {
        $this->standingPromotion = $standingPromotion;

        return $this;
    }

    /**
     * @return StandingRow
     */
    public static function create()
    {
        $factory = new StandingRowFactory();

        return $factory->create();
    }

    /**
     * @return StandingCell[]
     */
    public function getStandingCell()
    {
        return $this->standingCell;
    }

    /**
     * @param Collection|StandingCell[] $standingCell
     *
     * @return $this
     */
    public function setStandingCell(Collection $standingCell)
    {
        $this->standingCell = $standingCell;

        return $this;
    }

    /**
     * Add standingCell.
     *
     * @param StandingCell $standingCell
     *
     * @return StandingRow
     */
    public function addStandingCell(StandingCell $standingCell)
    {
        $this->standingCell[] = $standingCell;

        return $this;
    }

    /**
     * Remove standingCell.
     *
     * @param StandingCell $standingCell
     */
    public function removeStandingCell(StandingCell $standingCell)
    {
        $this->standingCell->removeElement($standingCell);
    }
}
