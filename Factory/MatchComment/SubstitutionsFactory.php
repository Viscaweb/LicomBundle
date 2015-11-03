<?php

namespace Visca\Bundle\LicomBundle\Factory\MatchComment;

use Visca\Bundle\LicomBundle\Factory\MatchComment\Abstracts\AbstractMatchCommentFactory;
use Visca\Bundle\LicomBundle\Entity\MatchComment\Substitutions;

/**
 * Class SubstitutionsFactory.
 */
class SubstitutionsFactory extends AbstractMatchCommentFactory
{
    /**
     * @return Substitutions
     */
    public function create()
    {
        $entity = new Substitutions();
        $entity->setIconHTML('<span class="sprite striped"></span>');

        return $entity;
    }
}
