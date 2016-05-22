<?php
namespace Visca\Bundle\LicomBundle\Events;

use Visca\Bundle\LicomBundle\Entity\Competition as LicomCompetition;

final class Competition extends AbstractEvent
{
    public static function listenByCompetition(LicomCompetition $competition)
    {
        return new static('competition.'.$competition->getId());
    }

    /**
     * @return string
     */
    public function getEventObject()
    {
        return 'competition';
    }
}
