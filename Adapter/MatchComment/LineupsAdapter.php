<?php

namespace Visca\Bundle\LicomBundle\Adapter\MatchComment;

use Visca\Bundle\LicomBundle\Adapter\MatchComment\Abstracts\AbstractMatchCommentAdapter;
use Visca\Bundle\LicomBundle\Entity\MatchComment\Lineups;
use Visca\Bundle\LicomBundle\Entity\MatchComment;
use Visca\Bundle\LicomBundle\Factory\MatchComment\LineupsFactory;

/**
 * Class LineupsAdapter.
 */
class LineupsAdapter extends AbstractMatchCommentAdapter
{
    /**
     * Adapt the inputObject to a Lineups entity.
     *
     * @param MatchComment $inputObject
     *
     * @return Lineups
     */
    public function process(MatchComment $inputObject)
    {
        $factory = new LineupsFactory();
        $finalMatchComment = $this->create(
            $inputObject,
            $factory
        );

        return $finalMatchComment;
    }
}
