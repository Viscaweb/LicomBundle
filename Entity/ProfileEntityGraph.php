<?php

namespace Visca\Bundle\LicomBundle\Entity;

use Visca\Bundle\CoreBundle\Entity\Traits\DeletableTrait;
use Visca\Bundle\LicomBundle\Factory\ProfileEntityGraphFactory;

/**
 * ProfileEntityGraph.
 */
class ProfileEntityGraph
{
    use DeletableTrait;

    /**
     * @var int
     */
    private $id;

    /**
     * @var Profile
     */
    private $profile;

    /**
     * @var int
     */
    private $label;

    /**
     * @var int
     */
    private $position;

    /**
     * @var Entity
     */
    private $entity;

    /**
     * @var int
     */
    private $entityId;

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Get Profile.
     *
     * @return Profile
     */
    public function getProfile()
    {
        return $this->profile;
    }

    /**
     * Set Profile.
     *
     * @param Profile $profile
     *
     * @return ProfileEntityGraph
     */
    public function setProfile(Profile $profile)
    {
        $this->profile = $profile;

        return $this;
    }

    /**
     * Get label.
     *
     * @return int
     */
    public function getLabel()
    {
        return $this->label;
    }

    /**
     * Set label.
     *
     * @param int $label
     *
     * @return ProfileEntityGraph
     */
    public function setLabel($label)
    {
        $this->label = $label;

        return $this;
    }

    /**
     * Get position.
     *
     * @return int
     */
    public function getPosition()
    {
        return $this->position;
    }

    /**
     * Set position.
     *
     * @param int $position
     *
     * @return ProfileEntityGraph
     */
    public function setPosition($position)
    {
        $this->position = $position;

        return $this;
    }

    /**
     * @return Entity
     */
    public function getEntity()
    {
        return $this->entity;
    }

    /**
     * @param Entity $entity
     *
     * @return $this
     */
    public function setEntity(Entity $entity)
    {
        $this->entity = $entity;

        return $this;
    }

    /**
     * @return int
     */
    public function getEntityId()
    {
        return $this->entityId;
    }

    /**
     * @param int $entityId
     *
     * @return $this
     */
    public function setEntityId($entityId)
    {
        $this->entityId = $entityId;

        return $this;
    }

    /**
     * @return ProfileEntityGraph
     */
    public static function create()
    {
        $factory = new ProfileEntityGraphFactory();

        return $factory->create();
    }
}
