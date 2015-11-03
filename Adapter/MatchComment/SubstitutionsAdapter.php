<?php

namespace Visca\Bundle\LicomBundle\Adapter\MatchComment;

use Visca\Bundle\LicomBundle\Adapter\MatchComment\Abstracts\AbstractMatchCommentAdapter;
use Visca\Bundle\LicomBundle\Entity\MatchComment\Substitutions;
use Visca\Bundle\LicomBundle\Entity\MatchComment;
use Visca\Bundle\LicomBundle\Factory\MatchComment\SubstitutionsFactory;

/**
 * Class SubstitutionsAdapter.
 */
class SubstitutionsAdapter extends AbstractMatchCommentAdapter
{
    /**
     * Adapt the inputObject to a Substitutions entity.
     *
     * @param MatchComment $inputObject
     *
     * @return Substitutions
     */
    public function process(MatchComment $inputObject)
    {
        $factory = new SubstitutionsFactory();
        $finalMatchComment = $this->create(
            $inputObject,
            $factory
        );

        return $finalMatchComment;
    }
}
