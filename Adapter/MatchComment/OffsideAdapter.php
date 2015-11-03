<?php

namespace Visca\Bundle\LicomBundle\Adapter\MatchComment;

use Visca\Bundle\LicomBundle\Adapter\MatchComment\Abstracts\AbstractMatchCommentAdapter;
use Visca\Bundle\LicomBundle\Entity\MatchComment\Offside;
use Visca\Bundle\LicomBundle\Entity\MatchComment;
use Visca\Bundle\LicomBundle\Factory\MatchComment\OffsideFactory;

/**
 * Class OffsideAdapter.
 */
class OffsideAdapter extends AbstractMatchCommentAdapter
{
    /**
     * Adapt the inputObject to a Offside entity.
     *
     * @param MatchComment $inputObject
     *
     * @return Offside
     */
    public function process(MatchComment $inputObject)
    {
        $factory = new OffsideFactory();
        $finalMatchComment = $this->create(
            $inputObject,
            $factory
        );

        return $finalMatchComment;
    }
}
