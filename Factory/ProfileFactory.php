<?php

namespace Visca\Bundle\LicomBundle\Factory;

use Visca\Bundle\CoreBundle\Factory\Abstracts\AbstractFactory;
use Visca\Bundle\LicomBundle\Entity\Profile;

/**
 * Class ProfileFactory.
 */
class ProfileFactory extends AbstractFactory
{
    /**
     * Creates an instance of an entity.
     *
     * @return Profile Empty entity
     */
    public function create()
    {
        $profile = new Profile();
        $profile
            ->setDel('no');

        return $profile;
    }
}
