<?php

namespace Visca\Bundle\LicomBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Visca\Bundle\CoreBundle\Entity\Traits\DeletableTrait;
use Visca\Bundle\LicomBundle\Entity\Interfaces\AuxTypeInterface;

/**
 * ParticipantAuxType.
 */
class ParticipantAuxType implements AuxTypeInterface
{
    use DeletableTrait;

    /**
     * @var int
     */
    private $id;

    /**
     * @var string
     */
    private $code;

    /**
     * @var string
     */
    private $name;

    /**
     * @var Collection
     */
    private $aux;

    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->aux = new ArrayCollection();
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
     * Set id.
     *
     * @param int $id
     *
     * @return ParticipantAuxType
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Get code.
     *
     * @return string
     */
    public function getCode()
    {
        return $this->code;
    }

    /**
     * Set code.
     *
     * @param string $code
     *
     * @return ParticipantAuxType
     */
    public function setCode($code)
    {
        $this->code = $code;

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
     * @return ParticipantAuxType
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Add participantAux.
     *
     * @param ParticipantAux $participantAux
     *
     * @return ParticipantAuxType
     */
    public function addParticipantAux(
        ParticipantAux $participantAux
    ) {
        $this->aux[] = $participantAux;

        return $this;
    }

    /**
     * Remove participantAux.
     *
     * @param ParticipantAux $participantAux
     */
    public function removeParticipantAux(
        ParticipantAux $participantAux
    ) {
        $this->aux->removeElement($participantAux);
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
}
