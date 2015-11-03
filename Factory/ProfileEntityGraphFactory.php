<?php

namespace Visca\Bundle\LicomBundle\Factory;

use Visca\Bundle\CoreBundle\Factory\Abstracts\AbstractFactory;
use Visca\Bundle\LicomBundle\Entity\ProfileEntityGraph;

/**
 * Class ProfileEntityGraphFactory.
 */
class ProfileEntityGraphFactory extends AbstractFactory
{
    /**
     * Creates an instance of an entity.
     *
     * @return ProfileEntityGraph Empty entity
     */
    public function create()
    {
        $entity = new ProfileEntityGraph();
        $entity->setDel('no');

        return $entity;
    }
}
