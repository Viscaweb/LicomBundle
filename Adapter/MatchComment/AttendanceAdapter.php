<?php

namespace Visca\Bundle\LicomBundle\Adapter\MatchComment;

use Visca\Bundle\LicomBundle\Adapter\MatchComment\Abstracts\AbstractMatchCommentAdapter;
use Visca\Bundle\LicomBundle\Entity\MatchComment\Attendance;
use Visca\Bundle\LicomBundle\Entity\MatchComment;
use Visca\Bundle\LicomBundle\Factory\MatchComment\AttendanceFactory;

/**
 * Class AttendanceAdapter.
 */
class AttendanceAdapter extends AbstractMatchCommentAdapter
{
    /**
     * Adapt the inputObject to a Attendance entity.
     *
     * @param MatchComment $inputObject
     *
     * @return Attendance
     */
    public function process(MatchComment $inputObject)
    {
        $factory = new AttendanceFactory();
        $finalMatchComment = $this->create(
            $inputObject,
            $factory
        );

        return $finalMatchComment;
    }
}
