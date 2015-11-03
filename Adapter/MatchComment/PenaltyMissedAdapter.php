<?php

namespace Visca\Bundle\LicomBundle\Adapter\MatchComment;

use Visca\Bundle\LicomBundle\Adapter\MatchComment\Abstracts\AbstractMatchCommentAdapter;
use Visca\Bundle\LicomBundle\Entity\MatchComment\PenaltyMissed;
use Visca\Bundle\LicomBundle\Entity\MatchComment;
use Visca\Bundle\LicomBundle\Factory\MatchComment\PenaltyMissedFactory;

/**
 * Class PenaltyMissedAdapter.
 */
class PenaltyMissedAdapter extends AbstractMatchCommentAdapter
{
    /**
     * Adapt the inputObject to a PenaltyMissed entity.
     *
     * @param MatchComment $inputObject
     *
     * @return PenaltyMissed
     */
    public function process(MatchComment $inputObject)
    {
        $factory = new PenaltyMissedFactory();
        $finalMatchComment = $this->create(
            $inputObject,
            $factory
        );

        return $finalMatchComment;
    }
}
