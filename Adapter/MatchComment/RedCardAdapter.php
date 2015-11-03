<?php

namespace Visca\Bundle\LicomBundle\Adapter\MatchComment;

use Visca\Bundle\LicomBundle\Adapter\MatchComment\Abstracts\AbstractMatchCommentAdapter;
use Visca\Bundle\LicomBundle\Entity\MatchComment\RedCard;
use Visca\Bundle\LicomBundle\Entity\MatchComment;
use Visca\Bundle\LicomBundle\Factory\MatchComment\RedCardFactory;

/**
 * Class RedCardAdapter.
 */
class RedCardAdapter extends AbstractMatchCommentAdapter
{
    /**
     * Adapt the inputObject to a RedCard entity.
     *
     * @param MatchComment $inputObject
     *
     * @return RedCard
     */
    public function process(MatchComment $inputObject)
    {
        $factory = new RedCardFactory();
        $finalMatchComment = $this->create(
            $inputObject,
            $factory
        );

        return $finalMatchComment;
    }
}
