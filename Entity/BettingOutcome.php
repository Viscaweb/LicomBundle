<?php

namespace Visca\Bundle\LicomBundle\Entity;

use Visca\Bundle\CoreBundle\Entity\Traits\DeletableTrait;
use Visca\Bundle\CoreBundle\Entity\Traits\OptionalDateTimeTrait;

/**
 * BettingOutcome.
 *
 * This model describe what's the context of a given MatchBettingOutcome.
 * The parameters you can see (iparam, iparam2, dparam, dparam2) are inspired by EnetPulse.
 *
 * Quantity of data: Since all the odds will be saved in here, this model usually contains a LARGE amount of rows.
 */
abstract class BettingOutcome
{
    use OptionalDateTimeTrait;
    use DeletableTrait;

    /**
     * @var int
     */
    protected $id;

    /**
     * @var Entity
     */
    protected $entity;

    /**
     * @var int
     */
    protected $entityId;

    /**
     * @var BettingOutcomeSubType
     */
    protected $subType;

    /**
     * @var BettingOutcomeScopeType
     */
    protected $scopeType;

    /**
     * @var string|null
     */
    protected $status;

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
     * @return MatchBettingOutcome
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
     * Get BettingOutcomeSubType.
     *
     * @return BettingOutcomeSubType
     */
    public function getSubType()
    {
        return $this->subType;
    }

    /**
     * Set BettingOutcomeSubType.
     *
     * @param BettingOutcomeSubType $subType
     *
     * @return MatchBettingOutcome
     */
    public function setSubType(
        BettingOutcomeSubType $subType
    ) {
        $this->subType = $subType;

        return $this;
    }

    /**
     * Get BettingOutcomeScopeType.
     *
     * @return BettingOutcomeScopeType
     */
    public function getScopeType()
    {
        return $this->scopeType;
    }

    /**
     * Set BettingOutcomeScopeType.
     *
     * @param BettingOutcomeScopeType $scopeType
     *
     * @return MatchBettingOutcome
     */
    public function setScopeType(
        BettingOutcomeScopeType $scopeType
    ) {
        $this->scopeType = $scopeType;

        return $this;
    }

    /**
     * Get status.
     *
     * @return string|null
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Set status.
     *
     * @param string|null $status
     *
     * @return MatchBettingOutcome
     */
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }
}
