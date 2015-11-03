<?php

namespace Visca\Bundle\LicomBundle\Adapter\MatchIncident;

use Visca\Bundle\LicomBundle\Adapter\MatchIncident\Abstracts\AbstractMatchIncidentAdapter;
use Visca\Bundle\LicomBundle\Entity\MatchIncident\PlayerChange;
use Visca\Bundle\LicomBundle\Entity\Team;
use Visca\Bundle\LicomBundle\Factory\MatchIncident\PlayerChangeFactory;

/**
 * Class PlayerChangeAdapter.
 */
class PlayerChangeAdapter extends AbstractMatchIncidentAdapter
{
    /**
     * Adapt the inputObjects to a PlayerChange entity.
     *
     * @return PlayerChange
     */
    public function process($inputObjects)
    {
        $factory = new PlayerChangeFactory();
        $finalMatchIncident = $this->create(
            $inputObjects,
            $factory
        );

        if (isset($inputObjects['SubstitutionIn'])) {
            $finalMatchIncident
                ->setParticipantIn(
                    $inputObjects['SubstitutionIn']
                        ->getParticipant()
                );
        } else {
            $finalMatchIncident
                ->setParticipantIn(
                    new Team()
                );
        }

        if (isset($inputObjects['SubstitutionOut'])) {
            $finalMatchIncident
                ->setParticipantOut(
                    $inputObjects['SubstitutionOut']
                        ->getParticipant()
                );
        } else {
            $finalMatchIncident
                ->setParticipantOut(
                    new Team()
                );
        }

        return $finalMatchIncident;
    }
}
