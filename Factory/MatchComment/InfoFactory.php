<?php

namespace Visca\Bundle\LicomBundle\Factory\MatchComment;

use Visca\Bundle\LicomBundle\Factory\MatchComment\Abstracts\AbstractMatchCommentFactory;
use Visca\Bundle\LicomBundle\Entity\MatchComment\Info;

/**
 * Class InfoFactory.
 */
class InfoFactory extends AbstractMatchCommentFactory
{
    /**
     * @return Info
     */
    public function create()
    {
        $entity = new Info();
        $entity->setIconHTML('<span class="sprite info"></span>');

        return $entity;
    }
}
