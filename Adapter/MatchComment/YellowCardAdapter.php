<?php

namespace Visca\Bundle\LicomBundle\Adapter\MatchComment;

use Visca\Bundle\LicomBundle\Adapter\MatchComment\Abstracts\AbstractMatchCommentAdapter;
use Visca\Bundle\LicomBundle\Entity\MatchComment\YellowCard;
use Visca\Bundle\LicomBundle\Entity\MatchComment;
use Visca\Bundle\LicomBundle\Factory\MatchComment\YellowCardFactory;

/**
 * Class YellowCardAdapter.
 */
class YellowCardAdapter extends AbstractMatchCommentAdapter
{
    /**
     * Adapt the inputObject to a YellowCard entity.
     *
     * @param MatchComment $inputObject
     *
     * @return YellowCard
     */
    public function process(MatchComment $inputObject)
    {
        $factory = new YellowCardFactory();
        $finalMatchComment = $this->create(
            $inputObject,
            $factory
        );

        return $finalMatchComment;
    }
}
