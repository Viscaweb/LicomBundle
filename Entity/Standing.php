<?php

namespace Visca\Bundle\LicomBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Visca\Bundle\CoreBundle\Entity\Traits\OptionalDateTimeTrait;
use Visca\Bundle\CoreBundle\Entity\Traits\DeletableTrait;
use Visca\Bundle\LicomBundle\Factory\StandingFactory;

/**
 * Standing.
 *
 * The Standing defines and contains all relationships needed to get the standing and his content.
 *
 * Quantity of data: This model usually does NOT contains a lot of entries.
 *
 * @example Standing of the teams 3rd round of Liga 2015/2016.
 * @example Standing of the players having the most red cards in Champions League.
 * @example Representation of the number of goals per periods for Paris Saint Germain
 *
 * @link http://bit.ly/StandingTable How to build a full standing table ?
 */
class Standing
{
    use OptionalDateTimeTrait;
    use DeletableTrait;

    /**
     * @var int
     */
    private $id;

    /**
     * @var Entity
     */
    private $entity;

    /**
     * @var int
     */
    private $entityId;

    /**
     * @var StandingType
     */
    private $standingType;

    /**
     * @var string|null
     */
    private $round;

    /**
     * @var string|null
     */
    private $name;

    /**
     * @var Collection|StandingRow[]
     */
    private $standingRow;

    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->standingRow = new ArrayCollection();
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
     * Get Entity.
     *
     * @return Entity
     */
    public function getEntity()
    {
        return $this->entity;
    }

    /**
     * Set Entity.
     *
     * @param Entity $entity
     *
     * @return Standing
     */
    public function setEntity(Entity $entity)
    {
        $this->entity = $entity;

        return $this;
    }

    /**
     * Get entityId.
     *
     * @return int
     */
    public function getEntityId()
    {
        return $this->entityId;
    }

    /**
     * Set entityId.
     *
     * @param int $entityId
     *
     * @return Standing
     */
    public function setEntityId($entityId)
    {
        $this->entityId = $entityId;

        return $this;
    }

    /**
     * Get StandingType.
     *
     * @return StandingType
     */
    public function getStandingType()
    {
        return $this->standingType;
    }

    /**
     * Set StandingType.
     *
     * @param StandingType $standingType
     *
     * @return Standing
     */
    public function setStandingType(StandingType $standingType)
    {
        $this->standingType = $standingType;

        return $this;
    }

    /**
     * Get round.
     *
     * @return string|null
     */
    public function getRound()
    {
        return $this->round;
    }

    /**
     * Set round.
     *
     * @param string|null $round
     *
     * @return Standing
     */
    public function setRound($round)
    {
        $this->round = $round;

        return $this;
    }

    /**
     * Get name.
     *
     * @return string|null
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set name.
     *
     * @param string|null $name
     *
     * @return Standing
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return Collection|StandingRow[]
     */
    public function getStandingRow()
    {
        return $this->standingRow;
    }

    /**
     * @param Collection|StandingRow[] $standingRow
     *
     * @return $this
     */
    public function setStandingRow(Collection $standingRow)
    {
        $this->standingRow = $standingRow;

        return $this;
    }

    /**
     * Add standingRow.
     *
     * @param StandingRow $standingRow
     *
     * @return Standing
     */
    public function addStandingRow(StandingRow $standingRow)
    {
        $this->standingRow[] = $standingRow;

        return $this;
    }

    /**
     * Remove standingRow.
     *
     * @param StandingRow $standingRow
     */
    public function removeStandingRow(StandingRow $standingRow)
    {
        $this->standingRow->removeElement($standingRow);
    }

    /**
     * @return Standing
     */
    public static function create()
    {
        $factory = new StandingFactory();

        return $factory->create();
    }
}
