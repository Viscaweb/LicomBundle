<?php

namespace Visca\Bundle\LicomBundle\Factory;

use Visca\Bundle\CoreBundle\Factory\Abstracts\AbstractFactory;
use Visca\Bundle\LicomBundle\Entity\MatchParticipant;

/**
 * Class MatchParticipantFactory.
 */
class MatchParticipantFactory extends AbstractFactory
{
    /**
     * Creates an instance of an entity.
     *
     * @return MatchParticipant Empty entity
     */
    public function create()
    {
        $matchParticipant = new MatchParticipant();
        $matchParticipant->setDel('no');

        return $matchParticipant;
    }
}
