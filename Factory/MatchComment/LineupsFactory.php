<?php

namespace Visca\Bundle\LicomBundle\Factory\MatchComment;

use Visca\Bundle\LicomBundle\Factory\MatchComment\Abstracts\AbstractMatchCommentFactory;
use Visca\Bundle\LicomBundle\Entity\MatchComment\Lineups;

/**
 * Class LineupsFactory.
 */
class LineupsFactory extends AbstractMatchCommentFactory
{
    /**
     * @return Lineups
     */
    public function create()
    {
        $entity = new Lineups();

        return $entity;
    }
}
