<?php

namespace Visca\Bundle\LicomBundle\Adapter\MatchComment;

use Visca\Bundle\LicomBundle\Adapter\MatchComment\Abstracts\AbstractMatchCommentAdapter;
use Visca\Bundle\LicomBundle\Entity\MatchComment\PenaltyScored;
use Visca\Bundle\LicomBundle\Entity\MatchComment;
use Visca\Bundle\LicomBundle\Factory\MatchComment\PenaltyScoredFactory;

/**
 * Class PenaltyScoredAdapter.
 */
class PenaltyScoredAdapter extends AbstractMatchCommentAdapter
{
    /**
     * Adapt the inputObject to a PenaltyScored entity.
     *
     * @param MatchComment $inputObject
     *
     * @return PenaltyScored
     */
    public function process(MatchComment $inputObject)
    {
        $factory = new PenaltyScoredFactory();
        $finalMatchComment = $this->create(
            $inputObject,
            $factory
        );

        return $finalMatchComment;
    }
}
