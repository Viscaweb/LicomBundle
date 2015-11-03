<?php

namespace Visca\Bundle\LicomBundle\Factory\MatchComment;

use Visca\Bundle\LicomBundle\Factory\MatchComment\Abstracts\AbstractMatchCommentFactory;
use Visca\Bundle\LicomBundle\Entity\MatchComment\BettingTips;

/**
 * Class BettingTipsFactory.
 */
class BettingTipsFactory extends AbstractMatchCommentFactory
{
    /**
     * @return BettingTips
     */
    public function create()
    {
        $entity = new BettingTips();

        return $entity;
    }
}
