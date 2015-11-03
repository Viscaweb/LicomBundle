<?php

namespace Visca\Bundle\LicomBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Visca\Bundle\CoreBundle\Entity\Traits\DeletableTrait;
use Visca\Bundle\LicomBundle\Entity\Interfaces\AuxTypeInterface;

/**
 * MatchAuxType.
 */
class MatchAuxType implements AuxTypeInterface
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
     * @var Collection|MatchAux[]
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
     * @return MatchAuxType
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
     * @return MatchAuxType
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
     * @return MatchAuxType
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Add matchAux.
     *
     * @param MatchAux $matchAux
     *
     * @return MatchAuxType
     */
    public function addAux(MatchAux $matchAux)
    {
        $this->aux[] = $matchAux;

        return $this;
    }

    /**
     * Remove matchAux.
     *
     * @param MatchAux $matchAux
     */
    public function removeAux(MatchAux $matchAux)
    {
        $this->aux->removeElement($matchAux);
    }

    /**
     * Get matchAux.
     *
     * @return Collection|MatchAux[]
     */
    public function getAux()
    {
        return $this->aux;
    }
}
