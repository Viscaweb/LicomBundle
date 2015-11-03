<?php

namespace Visca\Bundle\LicomBundle\Factory\MatchComment;

use Visca\Bundle\LicomBundle\Factory\MatchComment\Abstracts\AbstractMatchCommentFactory;
use Visca\Bundle\LicomBundle\Entity\MatchComment\Important;

/**
 * Class ImportantFactory.
 */
class ImportantFactory extends AbstractMatchCommentFactory
{
    /**
     * @return Important
     */
    public function create()
    {
        $entity = new Important();

        return $entity;
    }
}
