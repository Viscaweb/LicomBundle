<?php

namespace Visca\Bundle\LicomBundle\Factory;

use Visca\Bundle\CoreBundle\Factory\Abstracts\AbstractFactory;
use Visca\Bundle\LicomBundle\Entity\MatchAuxProfile;

/**
 * Class MatchAuxProfileFactory.
 */
class MatchAuxProfileFactory extends AbstractFactory
{
    /**
     * Creates an instance of an entity.
     *
     * @return MatchAuxProfile Empty entity
     */
    public function create()
    {
        $matchAuxProfile = new MatchAuxProfile();
        $matchAuxProfile
            ->setDel('no');

        return $matchAuxProfile;
    }
}
