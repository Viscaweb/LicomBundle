<?php

namespace Visca\Bundle\LicomViewBundle\Helper\Entity;

use Visca\Bundle\LicomBundle\Entity\Code\MatchStatusDescriptionCode;
use Visca\Bundle\LicomBundle\Entity\Enum\MatchStatusDescriptionCategoryType;
use Visca\Bundle\LicomBundle\Entity\Match;
use Visca\Bundle\LicomBundle\Entity\MatchStatusDescription;
use Visca\Bundle\SportBundle\Model\View\MatchStatus;

/**
 * Class MatchStatusDescriptionHelper.
 */
class MatchStatusDescriptionHelper
{
    /**
     * @param MatchStatusDescription $description The description
     * @param int                    $maxLength   Max status name length
     *
     * @return string
     */
    public function getShortName(
        MatchStatusDescription $description,
        $maxLength
    ) {
        return mb_substr($description->getName(), 0, $maxLength);
    }

    /**
     * Converts a Match to a MatchStatusView.
     *
     * @param Match $match Match
     *
     * @return MatchStatus
     */
    public function matchStatusViewFromMatch(Match $match)
    {
        $class = null;
        $content = null;
        $live = false;
        $matchStatusView = new MatchStatus();
        $matchStatusDescription = $match->getMatchStatusDescription();

        $statusId = $matchStatusDescription->getId();
        if ($statusId === MatchStatusDescriptionCode::NOT_STARTED_CODE) {
            $content = 'Not started';
        } elseif ($statusId === MatchStatusDescriptionCode::HALFTIME_CODE) {
            $content = 'Half-Time';
            $class = 'paused';
        } else {
            $statusCategoryCode = $matchStatusDescription->getCategory();
            if ($statusCategoryCode === MatchStatusDescriptionCategoryType::INPROGRESS) {
                $timeElapsed = $match->getTimeElapsed();
                $matchStatusView->setTimeElapsed($timeElapsed);
                $content = $this->getNameFirstLetters($matchStatusDescription);
                $class = ($timeElapsed === null) ? '' : 'live';
                $live = true;
            } else {
                $content = $matchStatusDescription->getName();
                $class = '';
            }
        }

        $matchStatusView->setStatusName($content);
        $matchStatusView->setCssClass($class);
        $matchStatusView->setLive($live);

        return $matchStatusView;
    }

    /**
     * @param MatchStatusDescription $matchStatusDescription MatchStatusDescription
     *
     * @return string
     */
    public function getNameFirstLetters(MatchStatusDescription $matchStatusDescription)
    {
        $content = $matchStatusDescription->getName();

        $tokens = explode(' ', $content);

        $content = '';
        foreach ($tokens as $token) {
            $content .= $token[0];
        }

        return $content;
    }
}
