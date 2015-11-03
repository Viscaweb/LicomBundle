<?php

namespace Visca\Bundle\LicomBundle\Entity\Interfaces;

use Doctrine\Common\Collections\Collection;

/**
 * Interface AuxTypeInterface.
 */
interface AuxTypeInterface
{
    /**
     * Getter for the id property.
     *
     * @return int
     */
    public function getId();

    /**
     * Getter for the code property.
     *
     * @return string
     */
    public function getCode();

    /**
     * Getter for the collection of Aux.
     *
     * @return Collection|AuxInterface[]
     */
    public function getAux();
}
