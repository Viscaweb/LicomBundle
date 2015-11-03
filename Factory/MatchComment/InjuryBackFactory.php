<?php

namespace Visca\Bundle\LicomBundle\Factory\MatchComment;

use Visca\Bundle\LicomBundle\Factory\MatchComment\Abstracts\AbstractMatchCommentFactory;
use Visca\Bundle\LicomBundle\Entity\MatchComment\InjuryBack;

/**
 * Class InjuryBackFactory.
 */
class InjuryBackFactory extends AbstractMatchCommentFactory
{
    /**
     * @return InjuryBack
     */
    public function create()
    {
        $entity = new InjuryBack();

        return $entity;
    }
}
