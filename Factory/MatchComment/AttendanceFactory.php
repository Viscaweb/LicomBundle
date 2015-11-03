<?php

namespace Visca\Bundle\LicomBundle\Factory\MatchComment;

use Visca\Bundle\LicomBundle\Factory\MatchComment\Abstracts\AbstractMatchCommentFactory;
use Visca\Bundle\LicomBundle\Entity\MatchComment\Attendance;

/**
 * Class AttendanceFactory.
 */
class AttendanceFactory extends AbstractMatchCommentFactory
{
    /**
     * @return Attendance
     */
    public function create()
    {
        $entity = new Attendance();

        return $entity;
    }
}
