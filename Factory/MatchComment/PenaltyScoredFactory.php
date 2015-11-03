<?php

namespace Visca\Bundle\LicomBundle\Factory\MatchComment;

use Visca\Bundle\LicomBundle\Factory\MatchComment\Abstracts\AbstractMatchCommentFactory;
use Visca\Bundle\LicomBundle\Entity\MatchComment\PenaltyScored;

/**
 * Class PenaltyScoredFactory.
 */
class PenaltyScoredFactory extends AbstractMatchCommentFactory
{
    /**
     * @return PenaltyScored
     */
    public function create()
    {
        $entity = new PenaltyScored();

        return $entity;
    }
}
