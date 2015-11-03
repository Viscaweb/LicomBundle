<?php

namespace Visca\Bundle\LicomBundle\Adapter\MatchComment;

use Visca\Bundle\LicomBundle\Adapter\MatchComment\Abstracts\AbstractMatchCommentAdapter;
use Visca\Bundle\LicomBundle\Entity\MatchComment\General;
use Visca\Bundle\LicomBundle\Entity\MatchComment;
use Visca\Bundle\LicomBundle\Factory\MatchComment\GeneralFactory;

/**
 * Class GeneralAdapter.
 */
class GeneralAdapter extends AbstractMatchCommentAdapter
{
    /**
     * Adapt the inputObject to a General entity.
     *
     * @param MatchComment $inputObject
     *
     * @return General
     */
    public function process(MatchComment $inputObject)
    {
        $factory = new GeneralFactory();
        $finalMatchComment = $this->create(
            $inputObject,
            $factory
        );

        return $finalMatchComment;
    }
}
