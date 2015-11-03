<?php

namespace Visca\Bundle\LicomViewBundle\Twig\Entity;

use Visca\Bundle\LicomBundle\Entity\Competition;
use Visca\Bundle\LicomViewBundle\Provider\Image\CompetitionImageProvider;
use Visca\Bundle\MediaBundle\Twig\Abstracts\AbstractTwigExtension;

/**
 * Class CompetitionExtension.
 */
class CompetitionExtension extends AbstractTwigExtension
{
    /**
     * @var CompetitionImageProvider
     */
    protected $imageProvider;

    /**
     * Constructor.
     *
     * @param CompetitionImageProvider $competitionImageProvider CompetitionImageProvider
     */
    public function __construct(
        CompetitionImageProvider $competitionImageProvider
    ) {
        parent::__construct($competitionImageProvider);
    }

    /**
     * {@inheritdoc}
     */
    public function getFunctions()
    {
        return [
            new \Twig_SimpleFunction(
                'competition_icon_small',
                [$this, 'getCompetitionIconSmall'],
                ['is_safe' => ['html']]
            ),
            new \Twig_SimpleFunction(
                'competition_icon_medium',
                [$this, 'getCompetitionIconMedium'],
                ['is_safe' => ['html']]
            ),
            new \Twig_SimpleFunction(
                'competition_icon_source_small',
                [$this, 'getCompetitionIconSourceSmall']
            ),
            new \Twig_SimpleFunction(
                'competition_icon_source_medium',
                [$this, 'getCompetitionIconSourceMedium']
            ),
        ];
    }

    /**
     * @param Competition $competition Competition object
     *
     * @return bool|string
     */
    public function getCompetitionIconSmall(Competition $competition)
    {
        return $this->getCompetitionIcon($competition, 's');
    }

    /**
     * @param Competition $competition Competition object
     *
     * @return bool|string
     */
    public function getCompetitionIconMedium(Competition $competition)
    {
        return $this->getCompetitionIcon($competition, 'm');
    }

    /**
     * @param Competition $competition Competition object
     *
     * @return bool|string
     */
    public function getCompetitionIconSourceSmall(Competition $competition)
    {
        return $this->getCompetitionIconSource($competition, 's');
    }

    /**
     * @param Competition $competition Competition object
     *
     * @return bool|string
     */
    public function getCompetitionIconSourceMedium(Competition $competition)
    {
        return $this->getCompetitionIconSource($competition, 'm');
    }

    /**
     * @param Competition $competition Competition object
     * @param string      $size        size
     *
     * @return bool|string
     */
    private function getCompetitionIcon(
        Competition $competition,
        $size
    ) {
        $this->imageProvider
            ->setCompetition($competition)
            ->setSize($size);
        $media = $this->imageProvider->getMedia();

        return $this->getIcon($media);
    }

    /**
     * @param Competition $competition Competition object
     * @param string      $size        size
     *
     * @return string
     */
    private function getCompetitionIconSource(
        Competition $competition,
        $size
    ) {
        $this->imageProvider
            ->setCompetition($competition)
            ->setSize($size);
        $media = $this->imageProvider->getMedia();

        return $this->getSource($media);
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'visca_licom_extension_entity_competition';
    }
}
