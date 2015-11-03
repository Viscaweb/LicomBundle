<?php

namespace Visca\Bundle\LicomBundle\Entity;

use Visca\Bundle\CoreBundle\Entity\Traits\OptionalDateTimeTrait;
use Visca\Bundle\CoreBundle\Entity\Traits\DeletableTrait;

/**
 * Media.
 *
 * This model is not used for the moment (v1.0).
 */
class Media
{
    use OptionalDateTimeTrait;
    use DeletableTrait;

    /**
     * @var int
     */
    private $id;

    /**
     * @var MediaType
     */
    private $mediaType;

    /**
     * @var MediaTheme
     */
    private $mediaTheme;

    /**
     * @var int
     */
    private $entityId;

    /**
     * @var string|null
     */
    private $legal;

    /**
     * @var string|null
     */
    private $usage;

    /**
     * @var string|null
     */
    private $urlDownload;

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
     * Get MediaType.
     *
     * @return MediaType
     */
    public function getMediaType()
    {
        return $this->mediaType;
    }

    /**
     * Set MediaType.
     *
     * @param MediaType $mediaType
     *
     * @return Media
     */
    public function setMediaType(MediaType $mediaType)
    {
        $this->mediaType = $mediaType;

        return $this;
    }

    /**
     * Get MediaTheme.
     *
     * @return MediaTheme
     */
    public function getMediaTheme()
    {
        return $this->mediaTheme;
    }

    /**
     * Set MediaTheme.
     *
     * @param MediaTheme $mediaTheme
     *
     * @return Media
     */
    public function setMediaTheme(MediaTheme $mediaTheme)
    {
        $this->mediaTheme = $mediaTheme;

        return $this;
    }

    /**
     * Get entityId.
     *
     * @return int
     */
    public function getEntityId()
    {
        return $this->entityId;
    }

    /**
     * Set entityId.
     *
     * @param int $entityId
     *
     * @return Media
     */
    public function setEntityId($entityId)
    {
        $this->entityId = $entityId;

        return $this;
    }

    /**
     * Get legal.
     *
     * @return string|null
     */
    public function getLegal()
    {
        return $this->legal;
    }

    /**
     * Set legal.
     *
     * @param string|null $legal
     *
     * @return Media
     */
    public function setLegal($legal)
    {
        $this->legal = $legal;

        return $this;
    }

    /**
     * Get usage.
     *
     * @return string|null
     */
    public function getUsage()
    {
        return $this->usage;
    }

    /**
     * Set usage.
     *
     * @param string|null $usage
     *
     * @return Media
     */
    public function setUsage($usage)
    {
        $this->usage = $usage;

        return $this;
    }

    /**
     * Get urlDownload.
     *
     * @return string|null
     */
    public function getUrlDownload()
    {
        return $this->urlDownload;
    }

    /**
     * Set urlDownload.
     *
     * @param string|null $urlDownload
     *
     * @return Media
     */
    public function setUrlDownload($urlDownload)
    {
        $this->urlDownload = $urlDownload;

        return $this;
    }
}
