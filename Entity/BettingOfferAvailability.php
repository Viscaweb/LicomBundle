<?php

namespace Visca\Bundle\LicomBundle\Entity;

use Visca\Bundle\CoreBundle\Entity\Traits\DeletableTrait;
use Visca\Bundle\CoreBundle\Entity\Traits\OptionalDateTimeTrait;

/**
 * BettingOfferAvailability.
 *
 * This model contains pre-calculated data saying if for a given entity (Competition, Match, etc..)
 * and the ID, odds are available or not.
 */
class BettingOfferAvailability
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
     * @var BettingOfferProvider
     */
    private $bettingOfferProvider;

    /**
     * @var BettingOutcomeType
     */
    private $bettingOutcomeType;

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
     * @return BettingOfferAvailability
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
     * @return BettingOfferAvailability
     */
    public function setEntityId($entityId)
    {
        $this->entityId = $entityId;

        return $this;
    }

    /**
     * Get BettingOfferProvider.
     *
     * @return BettingOfferProvider
     */
    public function getBettingOfferProvider()
    {
        return $this->bettingOfferProvider;
    }

    /**
     * Set BettingOfferProvider.
     *
     * @param BettingOfferProvider $bettingOfferProvider
     *
     * @return BettingOfferAvailability
     */
    public function setBettingOfferProvider(
        BettingOfferProvider $bettingOfferProvider
    ) {
        $this->bettingOfferProvider = $bettingOfferProvider;

        return $this;
    }

    /**
     * Get BettingOutcomeType.
     *
     * @return int
     */
    public function getBettingOutcomeType()
    {
        return $this->bettingOutcomeType;
    }

    /**
     * Set BettingOutcomeType.
     *
     * @param int $bettingOutcomeType
     *
     * @return BettingOfferAvailability
     */
    public function setBettingOutcomeType($bettingOutcomeType)
    {
        $this->bettingOutcomeType = $bettingOutcomeType;

        return $this;
    }
}
