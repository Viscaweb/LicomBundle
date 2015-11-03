<?php

namespace Visca\Bundle\LicomBundle\Adapter\MatchComment;

use Visca\Bundle\LicomBundle\Adapter\MatchComment\Abstracts\AbstractMatchCommentAdapter;
use Visca\Bundle\LicomBundle\Entity\MatchComment\Important;
use Visca\Bundle\LicomBundle\Entity\MatchComment;
use Visca\Bundle\LicomBundle\Factory\MatchComment\ImportantFactory;

/**
 * Class ImportantAdapter.
 */
class ImportantAdapter extends AbstractMatchCommentAdapter
{
    /**
     * Adapt the inputObject to a Important entity.
     *
     * @param MatchComment $inputObject
     *
     * @return Important
     */
    public function process(MatchComment $inputObject)
    {
        $factory = new ImportantFactory();
        $finalMatchComment = $this->create(
            $inputObject,
            $factory
        );

        return $finalMatchComment;
    }
}
