<?php

namespace Visca\Bundle\LicomBundle\Adapter\MatchComment;

use Visca\Bundle\LicomBundle\Adapter\MatchComment\Abstracts\AbstractMatchCommentAdapter;
use Visca\Bundle\LicomBundle\Entity\MatchComment\Injury;
use Visca\Bundle\LicomBundle\Entity\MatchComment;
use Visca\Bundle\LicomBundle\Factory\MatchComment\InjuryFactory;

/**
 * Class InjuryAdapter.
 */
class InjuryAdapter extends AbstractMatchCommentAdapter
{
    /**
     * Adapt the inputObject to a Injury entity.
     *
     * @param MatchComment $inputObject
     *
     * @return Injury
     */
    public function process(MatchComment $inputObject)
    {
        $factory = new InjuryFactory();
        $finalMatchComment = $this->create(
            $inputObject,
            $factory
        );

        return $finalMatchComment;
    }
}
