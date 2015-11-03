<?php

namespace Visca\Bundle\LicomBundle\Adapter\MatchComment;

use Visca\Bundle\LicomBundle\Adapter\MatchComment\Abstracts\AbstractMatchCommentAdapter;
use Visca\Bundle\LicomBundle\Entity\MatchComment\Goal;
use Visca\Bundle\LicomBundle\Entity\MatchComment;
use Visca\Bundle\LicomBundle\Factory\MatchComment\GoalFactory;

/**
 * Class GoalAdapter.
 */
class GoalAdapter extends AbstractMatchCommentAdapter
{
    /**
     * Adapt the inputObject to a Goal entity.
     *
     * @param MatchComment $inputObject
     *
     * @return Goal
     */
    public function process(MatchComment $inputObject)
    {
        $factory = new GoalFactory();
        $finalMatchComment = $this->create(
            $inputObject,
            $factory
        );

        return $finalMatchComment;
    }
}
