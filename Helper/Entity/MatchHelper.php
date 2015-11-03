<?php

namespace Visca\Bundle\LicomViewBundle\Helper\Entity;

use InvalidArgumentException;
use Visca\Bundle\LicomBundle\Entity\Match;
use Visca\Bundle\LicomBundle\Entity\MatchParticipant;
use Visca\Bundle\LicomBundle\Entity\Participant;

/**
 * Class MatchHelper.
 */
class MatchHelper
{
    const MATCH_RESULT_TYPE_RUNNING_SCORE = 6;
    const MATCH_RESULT_TYPE_HALFTIME = 5;

    /**
     * @param Match $match  The match
     * @param int   $number Match participant number (1 or 2)
     *
     * @return Participant
     */
    public function getParticipantByNumber(Match $match, $number)
    {
        foreach ($match->getMatchParticipant() as $matchParticipant) {
            if ($matchParticipant->getNumber() == $number) {
                return $matchParticipant->getParticipant();
            }
        }

        throw new InvalidArgumentException(
            sprintf('No Participant exists with number "%s"', $number)
        );
    }

    /**
     * @param Match $match
     * @param int   $participantNumber
     *
     * @return string
     */
    public function getMainResult(Match $match, $participantNumber)
    {
        return $this->getResult(
            $match,
            $participantNumber,
            static::MATCH_RESULT_TYPE_RUNNING_SCORE
        );
    }

    /**
     * @param Match $match
     *
     * @return bool
     */
    public function hasMainResult(Match $match)
    {
        foreach ($match->getMatchParticipant() as $matchParticipant) {
            foreach ($matchParticipant->getMatchResult() as $matchResult) {
                if ($matchResult->getMatchResultType()->getId() == static::MATCH_RESULT_TYPE_RUNNING_SCORE) {
                    return true;
                }
            }
        }

        return false;
    }

    /**
     * @param Match $match
     * @param int   $participantNumber
     * @param int   $resultType
     *
     * @return string
     */
    public function getResult(Match $match, $participantNumber, $resultType)
    {
        $matchParticipant = $this->getMatchParticipantByNumber(
            $match,
            $participantNumber
        );

        foreach ($matchParticipant->getMatchResult() as $matchResult) {
            if ($matchResult->getMatchResultType()->getId() == $resultType) {
                return $matchResult->getValue();
            }
        }

        return '';
    }

    /**
     * @param Match $match  The match
     * @param int   $number Match participant number (1 or 2)
     *
     * @return MatchParticipant
     */
    public function getMatchParticipantByNumber(Match $match, $number)
    {
        foreach ($match->getMatchParticipant() as $matchParticipant) {
            if ($matchParticipant->getNumber() == $number) {
                return $matchParticipant;
            }
        }

        throw new InvalidArgumentException(
            sprintf('No MatchParticipant exists with number "%s"', $number)
        );
    }

    /**
     * @param Match $match
     * @param int   $participantNumber
     *
     * @return string
     */
    public function getHalftimeResult(Match $match, $participantNumber)
    {
        return $this->getResult(
            $match,
            $participantNumber,
            static::MATCH_RESULT_TYPE_HALFTIME
        );
    }
}
