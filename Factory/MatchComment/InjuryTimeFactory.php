<?php

namespace Visca\Bundle\LicomBundle\Factory\MatchComment;

use Visca\Bundle\LicomBundle\Factory\MatchComment\Abstracts\AbstractMatchCommentFactory;
use Visca\Bundle\LicomBundle\Entity\MatchComment\InjuryTime;

/**
 * Class InjuryTimeFactory.
 */
class InjuryTimeFactory extends AbstractMatchCommentFactory
{
    /**
     * @return InjuryTime
     */
    public function create()
    {
        $entity = new InjuryTime();

        return $entity;
    }
}
