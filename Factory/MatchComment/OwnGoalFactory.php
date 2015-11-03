<?php

namespace Visca\Bundle\LicomBundle\Factory\MatchComment;

use Visca\Bundle\LicomBundle\Factory\MatchComment\Abstracts\AbstractMatchCommentFactory;
use Visca\Bundle\LicomBundle\Entity\MatchComment\OwnGoal;

/**
 * Class OwnGoalFactory.
 */
class OwnGoalFactory extends AbstractMatchCommentFactory
{
    /**
     * @return OwnGoal
     */
    public function create()
    {
        $entity = new OwnGoal();

        return $entity;
    }
}
