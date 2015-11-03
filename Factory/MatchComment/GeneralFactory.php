<?php

namespace Visca\Bundle\LicomBundle\Factory\MatchComment;

use Visca\Bundle\LicomBundle\Factory\MatchComment\Abstracts\AbstractMatchCommentFactory;
use Visca\Bundle\LicomBundle\Entity\MatchComment\General;

/**
 * Class GeneralFactory.
 */
class GeneralFactory extends AbstractMatchCommentFactory
{
    /**
     * @return General
     */
    public function create()
    {
        $entity = new General();
        $entity->setIconHTML('<span class="sprite info"></span>');

        return $entity;
    }
}
