<?php

namespace Visca\Bundle\LicomViewBundle\Helper\Entity;

use Visca\Bundle\LicomBundle\Entity\Participant;

/**
 * Class ParticipantHelper.
 */
class ParticipantHelper
{
    /**
     * @param Participant $participant The participant
     * @param int         $maxLength   Name max length required
     *
     * @return string
     */
    public function getName(Participant $participant, $maxLength)
    {
        $participantNameLength = mb_strlen($participant->getName());
        if ($participantNameLength > $maxLength) {
            return mb_substr($participant->getName(), 0, $maxLength - 1).'.';
        } else {
            return $participant->getName();
        }
    }
}
