<?php

namespace Visca\Bundle\LicomBundle\Entity\Traits;

use Doctrine\Common\Collections\Collection;
use InvalidArgumentException;
use Visca\Bundle\LicomBundle\Entity\Interfaces\AuxInterface;

/**
 * Class EntityWithAuxTrait.
 */
trait EntityWithAuxTrait
{
    /**
     * @param int   $key     The id for the aux required
     * @param mixed $default The default value if the aux is not found
     *
     * @return string The value of the aux
     */
    public function getAuxByKey($key, $default = null)
    {
        $auxCollection = $this->getAux();

        foreach ($auxCollection as $aux) {
            if (!$aux instanceof AuxInterface) {
                throw new InvalidArgumentException(
                    sprintf(
                        'Aux of type "%s" expected, "%s" given',
                        AuxInterface::class,
                        get_class($aux)
                    )
                );
            }

            if ($aux->getType()->getId() == $key) {
                return $aux->getValue();
            }
        }

        return $default;
    }

    /**
     * @return Collection
     */
    abstract public function getAux();
}
