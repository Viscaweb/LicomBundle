<?php

namespace Visca\Bundle\LicomBundle\Adapter\MatchComment;

use Visca\Bundle\LicomBundle\Adapter\MatchComment\Abstracts\AbstractMatchCommentAdapter;
use Visca\Bundle\LicomBundle\Entity\MatchComment\OwnGoal;
use Visca\Bundle\LicomBundle\Entity\MatchComment;
use Visca\Bundle\LicomBundle\Factory\MatchComment\OwnGoalFactory;

/**
 * Class OwnGoalAdapter.
 */
class OwnGoalAdapter extends AbstractMatchCommentAdapter
{
    /**
     * Adapt the inputObject to a OwnGoal entity.
     *
     * @param MatchComment $inputObject
     *
     * @return OwnGoal
     */
    public function process(MatchComment $inputObject)
    {
        $factory = new OwnGoalFactory();
        $finalMatchComment = $this->create(
            $inputObject,
            $factory
        );

        return $finalMatchComment;
    }
}
