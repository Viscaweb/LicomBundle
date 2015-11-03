<?php

namespace Visca\Bundle\LicomBundle\Factory\MatchComment;

use Visca\Bundle\LicomBundle\Factory\MatchComment\Abstracts\AbstractMatchCommentFactory;
use Visca\Bundle\LicomBundle\Entity\MatchComment\Goal;

/**
 * Class GoalFactory.
 */
class GoalFactory extends AbstractMatchCommentFactory
{
    /**
     * @return Goal
     */
    public function create()
    {
        $entity = new Goal();
        $entity->setIconHTML('<span class="sprite goal"></span>');

        return $entity;
    }
}
