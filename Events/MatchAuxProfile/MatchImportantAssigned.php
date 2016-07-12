<?php

namespace Visca\Bundle\LicomBundle\Events\MatchAuxProfile;

use Visca\Bundle\LicomBundle\Events\AbstractEvent;
use Visca\Bundle\LicomBundle\Events\Traits\ListenByMatchTrait;
use Visca\Bundle\LicomBundle\Events\Traits\ListenBySportTrait;

final class MatchImportantAssigned extends AbstractEvent
{
    use ListenByMatchTrait, ListenBySportTrait;

    /**
     * @return string
     */
    public function getEventObject()
    {
        return 'match_aux_profile_match_important_assigned';
    }
}