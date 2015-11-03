<?php

namespace Visca\Bundle\LicomBundle\Adapter\MatchComment;

use Visca\Bundle\LicomBundle\Adapter\MatchComment\Abstracts\AbstractMatchCommentAdapter;
use Visca\Bundle\LicomBundle\Entity\MatchComment\RefereeWhistle;
use Visca\Bundle\LicomBundle\Entity\MatchComment;
use Visca\Bundle\LicomBundle\Factory\MatchComment\RefereeWhistleFactory;

/**
 * Class RefereeWhistleAdapter.
 */
class RefereeWhistleAdapter extends AbstractMatchCommentAdapter
{
    /**
     * Adapt the inputObject to a RefereeWhistle entity.
     *
     * @param MatchComment $inputObject
     *
     * @return RefereeWhistle
     */
    public function process(MatchComment $inputObject)
    {
        $factory = new RefereeWhistleFactory();
        $finalMatchComment = $this->create(
            $inputObject,
            $factory
        );

        return $finalMatchComment;
    }
}
