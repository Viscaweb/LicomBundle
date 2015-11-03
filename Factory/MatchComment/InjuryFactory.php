<?php

namespace Visca\Bundle\LicomBundle\Factory\MatchComment;

use Visca\Bundle\LicomBundle\Factory\MatchComment\Abstracts\AbstractMatchCommentFactory;
use Visca\Bundle\LicomBundle\Entity\MatchComment\Injury;

/**
 * Class InjuryFactory.
 */
class InjuryFactory extends AbstractMatchCommentFactory
{
    /**
     * @return Injury
     */
    public function create()
    {
        $entity = new Injury();

        return $entity;
    }
}
