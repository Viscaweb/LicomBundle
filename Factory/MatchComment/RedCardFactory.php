<?php

namespace Visca\Bundle\LicomBundle\Factory\MatchComment;

use Visca\Bundle\LicomBundle\Factory\MatchComment\Abstracts\AbstractMatchCommentFactory;
use Visca\Bundle\LicomBundle\Entity\MatchComment\RedCard;

/**
 * Class RedCardFactory.
 */
class RedCardFactory extends AbstractMatchCommentFactory
{
    /**
     * @return RedCard
     */
    public function create()
    {
        $entity = new RedCard();
        $entity->setIconHTML('<span class="sprite red-card"></span>');

        return $entity;
    }
}
