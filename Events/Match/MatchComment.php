<?php
namespace Visca\Bundle\LicomBundle\Events\Match;

use Visca\Bundle\LicomBundle\Events\AbstractEvent;
use Visca\Bundle\LicomBundle\Entity\Match as LicomMatch;
use Visca\Bundle\LicomBundle\Entity\Team;

class MatchComment extends AbstractEvent
{
    public function listenByMatch(LicomMatch $match)
    {
        $this->setScope('match.'.$match->getId());

        return $this;
    }
    
    /**
     * @return string
     */
    public function getEventObject()
    {
        return 'match_comment';
    }
}