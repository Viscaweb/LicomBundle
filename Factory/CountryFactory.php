<?php

namespace Visca\Bundle\LicomBundle\Factory;

use Visca\Bundle\CoreBundle\Factory\Abstracts\AbstractFactory;
use Visca\Bundle\LicomBundle\Entity\Country;

/**
 * Class CountryFactory.
 */
class CountryFactory extends AbstractFactory
{
    /**
     * Creates an instance of an entity.
     *
     * @return Country Empty entity
     */
    public function create()
    {
        $country = new Country();
        $country->setDel('no');

        return $country;
    }
}
