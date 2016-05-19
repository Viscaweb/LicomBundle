<?php
namespace Visca\Bundle\LicomBundle\Events\Match;

use Visca\Bundle\LicomBundle\Events\AbstractEvent;
use Visca\Bundle\LicomBundle\Entity\Match as LicomMatch;

class MatchComment extends AbstractEvent
{
    public static function listenByMatch(LicomMatch $match)
    {
        return new static('match.'.$match->getId());
    }

    /**
     * @return string
     */
    public function getEventObject()
    {
        return 'match_comment';
    }
}