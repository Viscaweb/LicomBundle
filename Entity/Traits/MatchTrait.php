<?php

namespace Visca\Bundle\LicomBundle\Entity\Traits;

use Doctrine\Common\Collections\Collection;
use Visca\Bundle\LicomBundle\Entity\Code\MatchAuxProfileTypeCode;
use Visca\Bundle\LicomBundle\Entity\Code\MatchResultTypeCode;
use Visca\Bundle\LicomBundle\Entity\Competition;
use Visca\Bundle\LicomBundle\Entity\CompetitionSeasonStage;
use Visca\Bundle\LicomBundle\Entity\Country;
use Visca\Bundle\LicomBundle\Entity\MatchParticipant;
use Visca\Bundle\LicomBundle\Entity\MatchStatusDescription;
use Visca\Bundle\LicomBundle\Entity\Sport;
use Visca\Bundle\LicomBundle\Entity\Value\MatchAuxProfileValue;
use Visca\Bundle\LicomBundle\Exception\MatchParticipantNotFoundException;

/**
 * Class MatchTrait.
 */
trait MatchTrait
{
    /**
     * @return MatchStatusDescription
     */
    abstract public function getMatchStatusDescription();

    /**
     * @return CompetitionSeasonStage
     */
    abstract public function getCompetitionSeasonStage();

    /**
     * @throws MatchParticipantNotFoundException
     *
     * @return MatchParticipant
     */
    public function getHomeParticipant()
    {
        return $this->getMatchParticipantByNumber(1);
    }

    /**
     * @param int $participantNumber Participant number
     *
     * @throws MatchParticipantNotFoundException
     *
     * @return MatchParticipant
     */
    public function getMatchParticipantByNumber($participantNumber)
    {
        foreach ($this->getMatchParticipant() as $matchParticipant) {
            if ($matchParticipant->getNumber() === $participantNumber) {
                return $matchParticipant;
            }
        }

        throw new MatchParticipantNotFoundException(
            sprintf(
                'Could not find MatchParticipant with number "%d" for match.%d',
                $participantNumber,
                $this->getId()
            )
        );
    }

    /**
     * @return Collection|MatchParticipant[]
     */
    abstract public function getMatchParticipant();

    /**
     * @throws MatchParticipantNotFoundException
     *
     * @return MatchParticipant
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
     * @return Competition
     */
    public function getCompetition()
    {
        return $this->getCompetitionSeasonStage()->getCompetitionSeason()->getCompetition();
    }

    /**
     * @return Sport
     */
    public function getSport()
    {
        return $this->getCompetition()->getCompetitionCategory()->getSport();
    }

    /**
     * @return Country
     */
    public function getCountry()
    {
        return $this->getCompetition()->getCompetitionCategory()->getCountry();
    }

    /**
     * Returns true if the Match is Top.
     *
     * @return bool
     */
    public function isMatchTop()
    {
        $auxProfiles = $this->getMatchAuxProfile();
        // if we have aux data
        if ($auxProfiles->count() > 0) {
            // for eax aux data look if it's a Importance field
            foreach ($auxProfiles as $aux) {
                $auxTypeId = $aux->getMatchAuxProfileType()->getId();
                // if its a importance field
                if ($auxTypeId === MatchAuxProfileTypeCode::IMPORTANCE_CODE) {
                    // And its value is TOP, return true
                    if ($aux->getValue() === MatchAuxProfileValue::TOP) {
                        return true;
                    }
                    break;
                }
            }
        }

        return false;
    }
}
