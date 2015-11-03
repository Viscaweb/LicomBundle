<?php

namespace Visca\Bundle\LicomBundle\Adapter\MatchComment;

use Visca\Bundle\LicomBundle\Adapter\MatchComment\Abstracts\AbstractMatchCommentAdapter;
use Visca\Bundle\LicomBundle\Entity\MatchComment\Corner;
use Visca\Bundle\LicomBundle\Entity\MatchComment;
use Visca\Bundle\LicomBundle\Factory\MatchComment\CornerFactory;

/**
 * Class CornerAdapter.
 */
class CornerAdapter extends AbstractMatchCommentAdapter
{
    /**
     * Adapt the inputObject to a Corner entity.
     *
     * @param MatchComment $inputObject
     *
     * @return Corner
     */
    public function process(MatchComment $inputObject)
    {
        $factory = new CornerFactory();
        $finalMatchComment = $this->create(
            $inputObject,
            $factory
        );

        return $finalMatchComment;
    }
}
