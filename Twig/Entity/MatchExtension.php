<?php

namespace Visca\Bundle\LicomViewBundle\Twig\Entity;

use Twig_Extension;
use Visca\Bundle\LicomBundle\Entity\Code\MatchStatusDescriptionCode;
use Visca\Bundle\LicomBundle\Entity\Match;
use Visca\Bundle\LicomBundle\Entity\MatchParticipant;
use Visca\Bundle\LicomBundle\Entity\Participant;
use Visca\Bundle\LicomBundle\Entity\Team;
use Visca\Bundle\LicomViewBundle\Helper\Entity\MatchHelper;

/**
 * Class MatchExtension.
 */
class MatchExtension extends Twig_Extension
{
    /**
     * @var MatchHelper
     */
    private $matchHelper;

    /**
     * Constructor.
     *
     * @param MatchHelper $matchHelper Required service
     */
    public function __construct(MatchHelper $matchHelper)
    {
        $this->matchHelper = $matchHelper;
    }

    /**
     * {@inheritdoc}
     */
    public function getFunctions()
    {
        return [
            new \Twig_SimpleFunction(
                'match_participant',
                [$this, 'getMatchParticipant']
            ),
            new \Twig_SimpleFunction(
                'participant',
                [$this, 'getParticipant']
            ),
            new \Twig_SimpleFunction(
                'result_main',
                [$this, 'getMainResult']
            ),
            new \Twig_SimpleFunction(
                'has_result_main',
                [$this, 'hasMainResult']
            ),
            new \Twig_SimpleFunction(
                'result_halftime',
                [$this, 'getHalftimeResult']
            ),
            new \Twig_SimpleFunction(
                'has_match_started',
                [$this, 'hasMatchStarted']
            ),
        ];
    }

    /**
     * @param Match $match  The match
     * @param int   $number The participant number
     *
     * @return Participant
     */
    public function getParticipant(Match $match, $number)
    {
        try {
            return $this->matchHelper->getParticipantByNumber($match, $number);
        } catch (\Exception $e) {
            return new Team();
        }
    }

    /**
     * @param Match $match  The match
     * @param int   $number The participant number
     *
     * @return MatchParticipant
     */
    public function getMatchParticipant(Match $match, $number)
    {
        return $this->matchHelper->getMatchParticipantByNumber($match, $number);
    }

    /**
     * @param Match $match
     * @param int   $participantNumber
     *
     * @return string
     */
    public function getMainResult(Match $match, $participantNumber)
    {
        return $this->matchHelper->getMainResult($match, $participantNumber);
    }

    /**
     * @param Match $match
     *
     * @return bool
     */
    public function hasMainResult(Match $match)
    {
        return $this->matchHelper->hasMainResult($match);
    }

    /**
     * @param Match $match             Match entity.
     * @param int   $participantNumber Participant number.
     *
     * @return string
     */
    public function getHalftimeResult(Match $match, $participantNumber)
    {
        return $this->matchHelper->getHalftimeResult(
            $match,
            $participantNumber
        );
    }

    /**
     * Checks if a match has started.
     *
     * @param Match $match Match Entity
     *
     * @return bool
     */
    public function hasMatchStarted(Match $match)
    {
        $matchStatusDescriptionId = $match->getMatchStatusDescription()->getId();

        return ($matchStatusDescriptionId !== MatchStatusDescriptionCode::NOT_STARTED_CODE);
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'visca_licom_extension_entity_match';
    }
}
