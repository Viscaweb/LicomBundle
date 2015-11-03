<?php

namespace Visca\Bundle\LicomBundle\Adapter\MatchComment\Abstracts;

use Visca\Bundle\LicomBundle\Entity\MatchComment;
use Visca\Bundle\LicomBundle\Entity\MatchComment\Abstracts\AbstractMatchComment;
use Visca\Bundle\LicomBundle\Factory\MatchComment\Abstracts\AbstractMatchCommentFactory;

/**
 * Class AbstractMatchCommentAdapter.
 */
abstract class AbstractMatchCommentAdapter
{
    /**
     * Process the input object and return a MatchComment View Entity.
     *
     * @param MatchComment $inputObject
     */
    abstract public function process(MatchComment $inputObject);

    /**
     * Create the entitty from the factory and adapt generic data.
     *
     * @param MatchComment                $inputObject
     * @param AbstractMatchCommentFactory $factory
     *
     * @return AbstractMatchComment $finalMatchComment
     */
    protected function create(
        $inputObject,
        AbstractMatchCommentFactory $factory
    ) {
        $finalMatchComment = $factory->create();

        $finalMatchComment
            ->setText(
                $inputObject->getText()
            );

        $finalMatchComment
            ->setCommentaryHTML(
                $inputObject->getText()
            );

        $finalMatchComment
            ->setTimeElapsed(
                $inputObject->getTimeElapsed()
            );

        $finalMatchComment
            ->setTimeElapsedExtra(
                $inputObject->getTimeElapsedExtra()
            );

        $finalMatchComment
            ->setTime(
                $inputObject->getTime()
            );

        return $finalMatchComment;
    }
}
