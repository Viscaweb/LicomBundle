<?php

namespace Visca\Bundle\LicomBundle\Factory\MatchComment;

use Visca\Bundle\LicomBundle\Factory\MatchComment\Abstracts\AbstractMatchCommentFactory;
use Visca\Bundle\LicomBundle\Entity\MatchComment\Offside;

/**
 * Class OffsideFactory.
 */
class OffsideFactory extends AbstractMatchCommentFactory
{
    /**
     * @return Offside
     */
    public function create()
    {
        $entity = new Offside();

        return $entity;
    }
}
