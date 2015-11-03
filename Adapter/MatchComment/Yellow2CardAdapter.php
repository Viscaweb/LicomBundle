<?php

namespace Visca\Bundle\LicomBundle\Adapter\MatchComment;

use Visca\Bundle\LicomBundle\Adapter\MatchComment\Abstracts\AbstractMatchCommentAdapter;
use Visca\Bundle\LicomBundle\Entity\MatchComment\Yellow2Card;
use Visca\Bundle\LicomBundle\Entity\MatchComment;
use Visca\Bundle\LicomBundle\Factory\MatchComment\Yellow2CardFactory;

/**
 * Class Yellow2CardAdapter.
 */
class Yellow2CardAdapter extends AbstractMatchCommentAdapter
{
    /**
     * Adapt the inputObject to a Yellow2Card entity.
     *
     * @param MatchComment $inputObject
     *
     * @return Yellow2Card
     */
    public function process(MatchComment $inputObject)
    {
        $factory = new Yellow2CardFactory();
        $finalMatchComment = $this->create(
            $inputObject,
            $factory
        );

        return $finalMatchComment;
    }
}
