<?php

namespace Visca\Bundle\LicomBundle\Entity;

use DateTime;
use Visca\Bundle\CoreBundle\Entity\Traits\OptionalDateTimeTrait;
use Visca\Bundle\CoreBundle\Entity\Traits\DeletableTrait;

/**
 * MatchComment.
 *
 * This model contains all comments related to a given Match.
 *
 * The order of displaying is made with an algorithm based on timeElapsed,
 * timeElapsedExtra and time. The front-end projects must sort them using the field
 * “position”, without implementing any others algorithm.
 */
class MatchComment
{
    use OptionalDateTimeTrait;
    use DeletableTrait;

    /**
     * @var int
     */
    private $id;

    /**
     * @var Match
     */
    private $match;

    /**
     * @var Localization
     */
    private $localization;

    /**
     * @var MatchCommentType
     */
    private $matchCommentType;

    /**
     * @var string
     */
    private $text;

    /**
     * @var int|null
     */
    private $timeElapsed;

    /**
     * @var int|null
     */
    private $timeElapsedExtra;

    /**
     * @var DateTime|null
     */
    private $time;

    /**
     * Get id.
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Get Match.
     */
    public function getMatch()
    {
        return $this->match;
    }

    /**
     * Set Match.
     *
     * @param Match $match
     *
     * @return MatchComment
     */
    public function setMatch(Match $match)
    {
        $this->match = $match;

        return $this;
    }

    /**
     * Get Localization.
     *
     * @return Localization
     */
    public function getLocalization()
    {
        return $this->localization;
    }

    /**
     * Set LocalizationProfile.
     *
     * @param Localization $localization
     *
     * @return MatchComment
     */
    public function setLocalization(Localization $localization)
    {
        $this->localization = $localization;

        return $this;
    }

    /**
     * Get MatchCommentType.
     *
     * @return MatchCommentType
     */
    public function getMatchCommentType()
    {
        return $this->matchCommentType;
    }

    /**
     * Set MatchCommentType.
     *
     * @param MatchCommentType $matchCommentType
     *
     * @return MatchComment
     */
    public function setMatchCommentType(MatchCommentType $matchCommentType)
    {
        $this->matchCommentType = $matchCommentType;

        return $this;
    }

    /**
     * Get text.
     *
     * @return string
     */
    public function getText()
    {
        return $this->text;
    }

    /**
     * Set text.
     *
     * @param string $text
     *
     * @return MatchComment
     */
    public function setText($text)
    {
        $this->text = $text;

        return $this;
    }

    /**
     * Get timeElapsed.
     *
     * @return int|null
     */
    public function getTimeElapsed()
    {
        return $this->timeElapsed;
    }

    /**
     * Set timeElapsed.
     *
     * @param int|null $timeElapsed
     *
     * @return MatchComment
     */
    public function setTimeElapsed($timeElapsed)
    {
        $this->timeElapsed = $timeElapsed;

        return $this;
    }

    /**
     * Get timeElapsedExtra.
     *
     * @return int|null
     */
    public function getTimeElapsedExtra()
    {
        return $this->timeElapsedExtra;
    }

    /**
     * Set timeElapsedExtra.
     *
     * @param int|null $timeElapsedExtra
     *
     * @return MatchComment
     */
    public function setTimeElapsedExtra($timeElapsedExtra)
    {
        $this->timeElapsedExtra = $timeElapsedExtra;

        return $this;
    }

    /**
     * Get time.
     *
     * @return DateTime|null
     */
    public function getTime()
    {
        return $this->time;
    }

    /**
     * Set time.
     *
     * @param DateTime|null $time
     *
     * @return MatchComment
     */
    public function setTime(DateTime $time = null)
    {
        $this->time = $time;

        return $this;
    }
}
