<?php

namespace Visca\Bundle\LicomBundle\Adapter\MatchComment;

use Visca\Bundle\LicomBundle\Adapter\MatchComment\Abstracts\AbstractMatchCommentAdapter;
use Visca\Bundle\LicomBundle\Entity\MatchComment\InjuryBack;
use Visca\Bundle\LicomBundle\Entity\MatchComment;
use Visca\Bundle\LicomBundle\Factory\MatchComment\InjuryBackFactory;

/**
 * Class InjuryBackAdapter.
 */
class InjuryBackAdapter extends AbstractMatchCommentAdapter
{
    /**
     * Adapt the inputObject to a InjuryBack entity.
     *
     * @param MatchComment $inputObject
     *
     * @return InjuryBack
     */
    public function process(MatchComment $inputObject)
    {
        $factory = new InjuryBackFactory();
        $finalMatchComment = $this->create(
            $inputObject,
            $factory
        );

        return $finalMatchComment;
    }
}
