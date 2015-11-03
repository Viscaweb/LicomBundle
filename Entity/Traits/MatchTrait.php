<?php

namespace Visca\Bundle\LicomBundle\Entity\Traits;

use Doctrine\Common\Collections\Collection;
use Visca\Bundle\LicomBundle\Entity\Code\MatchResultTypeCode;
use Visca\Bundle\LicomBundle\Entity\MatchParticipant;
use Visca\Bundle\LicomBundle\Entity\MatchStatusDescription;
use Visca\Bundle\LicomBundle\Exception\MatchParticipantNotFoundException;

/**
 * Class MatchTrait.
 */
trait MatchTrait
{
    /**
     * @return MatchParticipant
     *
     * @throws MatchParticipantNotFoundException
     */
    public function getHomeParticipant()
    {
        return $this->getMatchParticipantByNumber(1);
    }

    /**
     * @param int $participantNumber Participant number
     *
     * @return MatchParticipant
     *
     * @throws MatchParticipantNotFoundException
     */
    public function getMatchParticipantByNumber($participantNumber)
    {
        foreach ($this->getMatchParticipant() as $matchParticipant) {
            if ($matchParticipant->getNumber() === $participantNumber) {
                return $matchParticipant;
            }
        }

        throw new MatchParticipantNotFoundException();
    }

    /**
     * @return Collection|MatchParticipant[]
     */
    abstract public function getMatchParticipant();

    /**
     * @return MatchParticipant
     *
     * @throws MatchParticipantNotFoundException
     */
    public function getAwayParticipant()
    {
        return $this->getMatchParticipantByNumber(2);
    }

    /**
     * @param $participantNumber
     *
     * @return string
     */
    public function getRunningScore($participantNumber)
    {
        return $this->getMatchResultByNumberAndResultTypeCode(
            $participantNumber,
            MatchResultTypeCode::RUNNING_SCORE_CODE
        );
    }

    /**
     * @param int    $participantNumber
     * @param string $resultTypeCode
     *
     * @return string
     */
    public function getMatchResultByNumberAndResultTypeCode(
        $participantNumber,
        $resultTypeCode
    ) {
        $matchParticipant = $this->getMatchParticipantByNumber(
            $participantNumber
        );

        if ($matchParticipant instanceof MatchParticipant) {
            foreach ($matchParticipant->getMatchResult() as $matchResult) {
                if ($matchResult->getMatchResultType()->getId()
                    == $resultTypeCode
                ) {
                    return $matchResult;
                }
            }
        }

        return '';
    }

    /**
     * @param $participantNumber
     *
     * @return string
     */
    public function getHalfTimeScore($participantNumber)
    {
        return $this->getMatchResultByNumberAndResultTypeCode(
            $participantNumber,
            MatchResultTypeCode::HALF_TIME_CODE
        );
    }

    /**
     * Returns true if a halftime score exists for this match.
     *
     * @return bool
     */
    public function hasHalfTimeScore()
    {
        foreach ($this->getMatchParticipant() as $matchParticipant) {
            foreach ($matchParticipant->getMatchResult() as $matchResult) {
                $matchResultTypeId = $matchResult
                    ->getMatchResultType()
                    ->getId();

                $isHalfTimeScore = $matchResultTypeId
                    == MatchResultTypeCode::HALF_TIME_CODE;

                if ($isHalfTimeScore) {
                    return true;
                }
            }
        }

        return false;
    }

    /**
     * Returns true if a any of teams playing in this match has red cards.
     *
     * @return bool
     */
    public function hasRedCardIncidents()
    {
        foreach ($this->getMatchParticipant() as $matchParticipant) {
            if ($matchParticipant->hasIncidentsWithRedCard()) {
                return true;
            }
        }

        return false;
    }

    /**
     * @return bool
     */
    public function isInProgress()
    {
        $inProgressCategory = MatchStatusDescription::IN_PROGRESS_KEY;
        $actualCategory = $this
            ->getMatchStatusDescription()
            ->getCategory();

        if ($inProgressCategory == $actualCategory) {
            return true;
        }

        return false;
    }

    /**
     * @return MatchStatusDescription
     */
    abstract public function getMatchStatusDescription();
}
