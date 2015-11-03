<?php

namespace Visca\Bundle\LicomBundle\Factory\MatchComment;

use Visca\Bundle\LicomBundle\Factory\MatchComment\Abstracts\AbstractMatchCommentFactory;
use Visca\Bundle\LicomBundle\Entity\MatchComment\Yellow2Card;

/**
 * Class Yellow2CardFactory.
 */
class Yellow2CardFactory extends AbstractMatchCommentFactory
{
    /**
     * @return Yellow2Card
     */
    public function create()
    {
        $entity = new Yellow2Card();
        $entity->setIconHTML('<span class="sprite yellow-red-card"></span>');

        return $entity;
    }
}
