<?php

namespace Visca\Bundle\LicomBundle\Factory\MatchComment;

use Visca\Bundle\LicomBundle\Factory\MatchComment\Abstracts\AbstractMatchCommentFactory;
use Visca\Bundle\LicomBundle\Entity\MatchComment\RefereeWhistle;

/**
 * Class RefereeWhistleFactory.
 */
class RefereeWhistleFactory extends AbstractMatchCommentFactory
{
    /**
     * @return RefereeWhistle
     */
    public function create()
    {
        $entity = new RefereeWhistle();

        return $entity;
    }
}
