<?php

namespace Visca\Bundle\LicomBundle\Entity\Interfaces;

/**
 * Interface AuxInterface.
 */
interface AuxInterface
{
    /**
     * Getter for the type.
     *
     * @return AuxTypeInterface
     */
    public function getType();

    /**
     * Getter for value property.
     *
     * @return string
     */
    public function getValue();
}
