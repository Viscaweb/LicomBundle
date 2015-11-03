<?php

namespace Visca\Bundle\LicomBundle\Adapter\MatchComment;

use Visca\Bundle\LicomBundle\Adapter\MatchComment\Abstracts\AbstractMatchCommentAdapter;
use Visca\Bundle\LicomBundle\Entity\MatchComment\BettingTips;
use Visca\Bundle\LicomBundle\Entity\MatchComment;
use Visca\Bundle\LicomBundle\Factory\MatchComment\BettingTipsFactory;

/**
 * Class BettingTipsAdapter.
 */
class BettingTipsAdapter extends AbstractMatchCommentAdapter
{
    /**
     * Adapt the inputObject to a BettingTips entity.
     *
     * @param MatchComment $inputObject
     *
     * @return BettingTips
     */
    public function process(MatchComment $inputObject)
    {
        $factory = new BettingTipsFactory();
        $finalMatchComment = $this->create(
            $inputObject,
            $factory
        );

        return $finalMatchComment;
    }
}
