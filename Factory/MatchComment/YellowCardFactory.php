<?php

namespace Visca\Bundle\LicomBundle\Factory\MatchComment;

use Visca\Bundle\LicomBundle\Factory\MatchComment\Abstracts\AbstractMatchCommentFactory;
use Visca\Bundle\LicomBundle\Entity\MatchComment\YellowCard;

/**
 * Class YellowCardFactory.
 */
class YellowCardFactory extends AbstractMatchCommentFactory
{
    /**
     * @return YellowCard
     */
    public function create()
    {
        $entity = new YellowCard();
        $entity->setIconHTML('<span class="sprite yellow-card"></span>');

        return $entity;
    }
}
