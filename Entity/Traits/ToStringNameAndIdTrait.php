<?php

namespace Visca\Bundle\LicomBundle\Entity\Traits;

/**
 * Class ToStringNameAndIdTrait.
 */
trait ToStringNameAndIdTrait
{
    /**
     * @return string
     */
    public function __toString()
    {
        return sprintf('%s(%s)', $this->getName(), $this->getId());
    }
}