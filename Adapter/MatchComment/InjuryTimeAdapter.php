<?php

namespace Visca\Bundle\LicomBundle\Adapter\MatchComment;

use Visca\Bundle\LicomBundle\Adapter\MatchComment\Abstracts\AbstractMatchCommentAdapter;
use Visca\Bundle\LicomBundle\Entity\MatchComment\InjuryTime;
use Visca\Bundle\LicomBundle\Entity\MatchComment;
use Visca\Bundle\LicomBundle\Factory\MatchComment\InjuryTimeFactory;

/**
 * Class InjuryTimeAdapter.
 */
class InjuryTimeAdapter extends AbstractMatchCommentAdapter
{
    /**
     * Adapt the inputObject to a InjuryTime entity.
     *
     * @param MatchComment $inputObject
     *
     * @return InjuryTime
     */
    public function process(MatchComment $inputObject)
    {
        $factory = new InjuryTimeFactory();
        $finalMatchComment = $this->create(
            $inputObject,
            $factory
        );

        return $finalMatchComment;
    }
}
