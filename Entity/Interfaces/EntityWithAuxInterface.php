<?php

namespace Visca\Bundle\LicomBundle\Entity\Interfaces;

use Doctrine\Common\Collections\Collection;

/**
 * Interface EntityWithAuxInterface.
 */
interface EntityWithAuxInterface
{
    /**
     * @return Collection|AuxInterface[]
     */
    public function getAux();

    /**
     * @param int   $key     The id for the aux required
     * @param mixed $default The default value if the aux is not found
     *
     * @return string The value of the aux
     */
    public function getAuxByKey($key, $default = null);
}
