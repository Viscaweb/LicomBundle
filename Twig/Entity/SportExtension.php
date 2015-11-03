<?php

namespace Visca\Bundle\LicomViewBundle\Twig\Entity;

use Visca\Bundle\LicomBundle\Entity\Sport;
use Visca\Bundle\LicomViewBundle\Provider\Image\SportImageProvider;
use Visca\Bundle\MediaBundle\Twig\Abstracts\AbstractTwigExtension;

/**
 * Class SportExtension.
 */
class SportExtension extends AbstractTwigExtension
{
    /**
     * @var SportImageProvider
     */
    protected $imageProvider;

    /**
     * Constructor.
     *
     * @param SportImageProvider $sportImageProvider SportImageProvider
     */
    public function __construct(
        SportImageProvider $sportImageProvider
    ) {
        parent::__construct($sportImageProvider);
    }

    /**
     * {@inheritdoc}
     */
    public function getFunctions()
    {
        return [
            new \Twig_SimpleFunction(
                'sport_icon_small',
                [$this, 'getSportIconSmall'],
                ['is_safe' => ['html']]
            ),
            new \Twig_SimpleFunction(
                'sport_icon_source_small',
                [$this, 'getSportIconSourceSmall']
            ),
            new \Twig_SimpleFunction(
                'sport_icon_medium',
                [$this, 'getSportIconMedium'],
                ['is_safe' => ['html']]
            ),
            new \Twig_SimpleFunction(
                'sport_icon_source_medium',
                [$this, 'getSportIconSourceMedium']
            ),
        ];
    }

    /**
     * @param Sport $sport Sport object
     *
     * @return bool|string
     */
    public function getSportIconSmall(Sport $sport)
    {
        return $this->getSportIcon($sport, 's');
    }

    /**
     * @param Sport $sport Sport object
     *
     * @return bool|string
     */
    public function getSportIconMedium(Sport $sport)
    {
        return $this->getSportIcon($sport, 'm');
    }

    /**
     * @param Sport $sport Sport object
     *
     * @return bool|string
     */
    public function getSportIconSourceSmall(Sport $sport)
    {
        return $this->getSportIconSource($sport, 's');
    }

    /**
     * @param Sport $sport Sport object
     *
     * @return bool|string
     */
    public function getSportIconSourceMedium(Sport $sport)
    {
        return $this->getSportIconSource($sport, 'm');
    }

    /**
     * @param Sport  $sport Sport object
     * @param string $size  Size
     *
     * @return bool|string
     */
    private function getSportIcon(
        Sport $sport,
        $size
    ) {
        $this->imageProvider
            ->setSport($sport)
            ->setSize($size);
        $media = $this->imageProvider->getMedia();

        return $this->getIcon($media);
    }

    /**
     * @param Sport  $sport Sport object
     * @param string $size  Size
     *
     * @return string
     */
    private function getSportIconSource(
        Sport $sport,
        $size
    ) {
        $this->imageProvider
            ->setSport($sport)
            ->setSize($size);
        $media = $this->imageProvider->getMedia();

        return $this->getSource($media);
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'visca_licom_extension_entity_sport';
    }
}
