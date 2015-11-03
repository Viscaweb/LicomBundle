<?php

namespace Visca\Bundle\LicomBundle\Factory\MatchComment;

use Visca\Bundle\LicomBundle\Factory\MatchComment\Abstracts\AbstractMatchCommentFactory;
use Visca\Bundle\LicomBundle\Entity\MatchComment\Corner;

/**
 * Class CornerFactory.
 */
class CornerFactory extends AbstractMatchCommentFactory
{
    /**
     * @return Corner
     */
    public function create()
    {
        $entity = new Corner();
        $entity->setIconHTML('<span class="sprite corner-flag"></span>');

        return $entity;
    }
}
