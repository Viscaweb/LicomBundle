<?php
namespace Visca\Bundle\LicomBundle\Events\Match\MatchStatus;

use Visca\Bundle\LicomBundle\Events\Match\MatchStatus;

class MatchBegins extends MatchStatus
{
    /**
     * @return string
     */
    public function getEventObject()
    {
        return 'match_begins';
    }
}