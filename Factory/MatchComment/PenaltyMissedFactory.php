<?php

namespace Visca\Bundle\LicomBundle\Factory\MatchComment;

use Visca\Bundle\LicomBundle\Factory\MatchComment\Abstracts\AbstractMatchCommentFactory;
use Visca\Bundle\LicomBundle\Entity\MatchComment\PenaltyMissed;

/**
 * Class PenaltyMissedFactory.
 */
class PenaltyMissedFactory extends AbstractMatchCommentFactory
{
    /**
     * @return PenaltyMissed
     */
    public function create()
    {
        $entity = new PenaltyMissed();

        return $entity;
    }
}
