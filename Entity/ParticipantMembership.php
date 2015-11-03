<?php

namespace Visca\Bundle\LicomBundle\Entity;

use Visca\Bundle\CoreBundle\Entity\Traits\OptionalDateTimeTrait;
use Visca\Bundle\CoreBundle\Entity\Traits\DeletableTrait;
use Visca\Bundle\LicomBundle\Entity\Traits\OptionalPeriodTrait;

/**
 * ParticipantMembership.
 *
 * This model associate one or many relationship from a Participant to any other Entity (check examples).
 *
 * Note: some players have many relationship, for instance, Messi has an association
 * to the Team ‘FC Barcelona’, and to the country ‘Argentina’.
 *
 * Quantity of data: The number of Participant is already large, and we have
 * at least one ParticipantMembership per Participant.
 *
 * This model usually contains a LARGE amount of rows.
 */
class ParticipantMembership
{
    use OptionalDateTimeTrait;
    use DeletableTrait;
    use OptionalPeriodTrait;

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
     * @var Participant
     */
    private $participant;

    /**
     * @var string
     */
    private $participantType;

    /**
     * @var int
     */
    private $active;

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
     * @return ParticipantMembership
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
     * @return ParticipantMembership
     */
    public function setEntityId($entityId)
    {
        $this->entityId = $entityId;

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
     * @return ParticipantMembership
     */
    public function setParticipant(Participant $participant)
    {
        $this->participant = $participant;

        return $this;
    }

    /**
     * Get participantType.
     *
     * @return string
     */
    public function getParticipantType()
    {
        return $this->participantType;
    }

    /**
     * Set participantType.
     *
     * @param string $participantType
     *
     * @return ParticipantMembership
     */
    public function setParticipantType($participantType)
    {
        $this->participantType = $participantType;

        return $this;
    }

    /**
     * Get active.
     *
     * @return int
     */
    public function getActive()
    {
        return $this->active;
    }

    /**
     * Set active.
     *
     * @param int $active
     *
     * @return ParticipantMembership
     */
    public function setActive($active)
    {
        $this->active = $active;

        return $this;
    }
}
