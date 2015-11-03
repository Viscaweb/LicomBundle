<?php

namespace Visca\Bundle\LicomBundle\Entity\MatchComment\Abstracts;

/**
 * Class AbstractMatchComment}.
 */
abstract class AbstractMatchComment
{
    /**
     * HTML code to show the icon.
     *
     * @var string
     */
    protected $iconHTML;

    /**
     * HTML code of the commentary.
     *
     * @var string
     */
    protected $commentaryHTML;

    /**
     * @var int
     */
    private $id;
    /**
     * @var int
     */
    private $Match;
    /**
     * @var int
     */
    private $LocalizationProfile;
    /**
     * @var int
     */
    private $MatchCommentType;
    /**
     * @var string
     */
    private $text;
    /**
     * @var int
     */
    private $timeElapsed;
    /**
     * @var int
     */
    private $timeElapsedExtra;
    /**
     * @var \DateTime
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
     *
     * @return int
     */
    public function getMatch()
    {
        return $this->Match;
    }

    /**
     * Set Match.
     *
     * @param int $match Match id
     *
     * @return AbstractMatchComment
     */
    public function setMatch($match)
    {
        $this->Match = $match;

        return $this;
    }

    /**
     * Get LocalizationProfile.
     *
     * @return int
     */
    public function getLocalizationProfile()
    {
        return $this->LocalizationProfile;
    }

    /**
     * Set LocalizationProfile.
     *
     * @param int $localizationProfile LocalizationProfile id
     *
     * @return AbstractMatchComment
     */
    public function setLocalizationProfile($localizationProfile)
    {
        $this->LocalizationProfile = $localizationProfile;

        return $this;
    }

    /**
     * Get MatchCommentType.
     *
     * @return int
     */
    public function getMatchCommentType()
    {
        return $this->MatchCommentType;
    }

    /**
     * Set MatchCommentType.
     *
     * @param int $matchCommentType MatchCommentType code
     *
     * @return AbstractMatchComment
     */
    public function setMatchCommentType($matchCommentType)
    {
        $this->MatchCommentType = $matchCommentType;

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
     * @param string $text Text
     *
     * @return AbstractMatchComment
     */
    public function setText($text)
    {
        $this->text = $text;

        return $this;
    }

    /**
     * Get timeElapsed.
     *
     * @return int
     */
    public function getTimeElapsed()
    {
        return $this->timeElapsed;
    }

    /**
     * Set timeElapsed.
     *
     * @param int $timeElapsed Time elapsed
     *
     * @return AbstractMatchComment
     */
    public function setTimeElapsed($timeElapsed)
    {
        $this->timeElapsed = $timeElapsed;

        return $this;
    }

    /**
     * Get timeElapsedExtra.
     *
     * @return int
     */
    public function getTimeElapsedExtra()
    {
        return $this->timeElapsedExtra;
    }

    /**
     * Set timeElapsedExtra.
     *
     * @param int $timeElapsedExtra time elapsed extra
     *
     * @return AbstractMatchComment
     */
    public function setTimeElapsedExtra($timeElapsedExtra)
    {
        $this->timeElapsedExtra = $timeElapsedExtra;

        return $this;
    }

    /**
     * Get time.
     *
     * @return \DateTime
     */
    public function getTime()
    {
        return $this->time;
    }

    /**
     * Set time.
     *
     * @param \DateTime $time Time
     *
     * @return AbstractMatchComment
     */
    public function setTime($time)
    {
        $this->time = $time;

        return $this;
    }

    /**
     * @return string
     */
    public function getIconHTML()
    {
        return $this->iconHTML;
    }

    /**
     * @param string $iconHTML icon HTML
     *
     * @return AbstractMatchComment
     */
    public function setIconHTML($iconHTML)
    {
        $this->iconHTML = $iconHTML;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getCommentaryHTML()
    {
        return $this->commentaryHTML;
    }

    /**
     * @param mixed $commentaryHTML Comment HTML
     *
     * @return AbstractMatchComment
     */
    public function setCommentaryHTML($commentaryHTML)
    {
        $this->commentaryHTML = $commentaryHTML;

        return $this;
    }
}
