<?php

namespace Visca\Bundle\LicomBundle\Adapter\MatchComment;

use Visca\Bundle\LicomBundle\Adapter\MatchComment\Abstracts\AbstractMatchCommentAdapter;
use Visca\Bundle\LicomBundle\Entity\MatchComment\Info;
use Visca\Bundle\LicomBundle\Entity\MatchComment;
use Visca\Bundle\LicomBundle\Factory\MatchComment\InfoFactory;

/**
 * Class InfoAdapter.
 */
class InfoAdapter extends AbstractMatchCommentAdapter
{
    /**
     * Adapt the inputObject to a Info entity.
     *
     * @param MatchComment $inputObject
     *
     * @return Info
     */
    public function process(MatchComment $inputObject)
    {
        $factory = new InfoFactory();
        $finalMatchComment = $this->create(
            $inputObject,
            $factory
        );

        return $finalMatchComment;
    }
}
