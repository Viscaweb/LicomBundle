<?php

namespace Visca\Bundle\LicomBundle\Adapter\MatchIncident\Abstracts;

use Visca\Bundle\LicomBundle\Entity\MatchIncident;
use Visca\Bundle\LicomBundle\Entity\MatchIncident\Abstracts\AbstractMatchIncident;
use Visca\Bundle\LicomBundle\Factory\MatchIncident\Abstracts\AbstractMatchIncidentFactory;
use Visca\Bundle\LicomBundle\Services\MatchIncidentPeriodHelper;

/**
 * Class AbstractMatchIncidentAdapter.
 */
abstract class AbstractMatchIncidentAdapter
{
    /**
     * Process the input object/s and return a MatchIncident Entity.
     *
     * @param array
     *
     * @return AbstractMatchIncident
     */
    abstract public function process($inputObjects);

    /**
     * Create the entity from the factory and adapt generic data.
     *
     * @param array                        $inputObjects
     * @param AbstractMatchIncidentFactory $factory
     *
     * @return AbstractMatchIncident $finalMatchIncident
     */
    protected function create(
        $inputObjects,
        AbstractMatchIncidentFactory $factory
    ) {
        $finalMatchIncident = $factory->create();

        $finalMatchIncident
            ->setIsHome($inputObjects['isHome']);
        /*
         * retrieve the code of the first MatchIncident
         * enough to know the generic data of the Incident
         */
        $code = $inputObjects['code'];

        $finalMatchIncident
            ->setTimeElapsed(
                $inputObjects[$code]
                    ->getTimeElapsed()
            );

        $finalMatchIncident
            ->setTimeElapsedExtra(
                $inputObjects[$code]
                    ->getTimeElapsedExtra()
            );

        $finalMatchIncident
            ->setPosition(
                $inputObjects[$code]
                    ->getPosition()
            );

        /*
         * calculate the period.
         * by the moment only Soccer is available
         */
        $mipHelper = new MatchIncidentPeriodHelper();
        $finalMatchIncident
            ->setOrdinalPeriod(
                $mipHelper
                    ->getOrdinalPeriod($inputObjects[$code])
            );

        return $finalMatchIncident;
    }

    /**
     * @param array                 $inputObjects
     * @param AbstractMatchIncident $finalMatchIncident
     *
     * @return AbstractMatchIncident $finalMatchIncident
     */
    protected function putParticipantInMatchIncident(
        $inputObjects,
        AbstractMatchIncident $finalMatchIncident
    ) {
        $code = $inputObjects['code'];
        $finalMatchIncident
            ->setParticipant(
                $inputObjects[$code]
                    ->getParticipant()
            );

        return $finalMatchIncident;
    }
}
