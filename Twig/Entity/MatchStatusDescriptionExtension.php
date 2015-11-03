<?php

namespace Visca\Bundle\LicomViewBundle\Twig\Entity;

use AppBundle\Detector\ViewDetector;
use Twig_Extension;
use Visca\Bundle\LicomBundle\Entity\Match;
use Visca\Bundle\LicomBundle\Entity\MatchStatusDescription;
use Visca\Bundle\LicomViewBundle\Helper\Entity\MatchStatusDescriptionHelper;

/**
 * Class MatchStatusDescriptionExtension.
 */
class MatchStatusDescriptionExtension extends Twig_Extension
{
    /**
     * @var MatchStatusDescriptionHelper
     */
    private $helper;

    /**
     * @var ViewDetector
     */
    private $viewDetector;

    /**
     * MatchStatusDescriptionExtension constructor.
     *
     * @param MatchStatusDescriptionHelper $helper       Required service
     * @param ViewDetector                 $viewDetector ViewDetector
     */
    public function __construct(
        MatchStatusDescriptionHelper $helper,
        ViewDetector $viewDetector
    ) {
        $this->helper = $helper;
        $this->viewDetector = $viewDetector;
    }

    /**
     * {@inheritdoc}
     */
    public function getFunctions()
    {
        return [
            new \Twig_SimpleFunction(
                'match_status_short_name',
                [$this, 'getMatchStatusDescriptionShortName']
            ),
            new \Twig_SimpleFunction(
                'match_status_wrapper_css',
                [$this, 'getMatchStatusWrapperCss'],
                ['is_safe' => ['html']]
            ),
            new \Twig_SimpleFunction(
                'match_status_content',
                [$this, 'getMatchStatusContent'],
                ['is_safe' => ['html'], 'needs_environment' => true]
            ),
            new \Twig_SimpleFunction(
                'match_status_is_live',
                [$this, 'isMatchLive']
            ),
        ];
    }

    /**
     * @param MatchStatusDescription $status
     * @param int                    $maxLength
     *
     * @return string
     */
    public function getMatchStatusDescriptionShortName(
        MatchStatusDescription $status,
        $maxLength = 2
    ) {
        return $this->helper->getShortName($status, $maxLength);
    }

    /**
     * @param \Twig_Environment $twig  Twig environment
     * @param Match             $match Match entity.
     *
     * @return bool|string
     */
    public function getMatchStatusContent(\Twig_Environment $twig, Match $match)
    {
        $view = $this->helper->matchStatusViewFromMatch($match);

        if (!$this->viewDetector->loadMobileApp()) {
            $template = 'ViscaLicomBundle:Extension:matchStatus.html.twig';
        } else {
            $template = 'ViscaLicomBundle:Extension:matchStatus.mobile.html.twig';
        }

        $html = $twig->render(
            $template,
            ['modelView' => $view]
        );

        return $html;
    }

    /**
     * Gets the css class.
     *
     * @param Match $match Match entity.
     *
     * @return bool|string
     */
    public function getMatchStatusWrapperCss(Match $match)
    {
        $view = $this->helper->matchStatusViewFromMatch($match);

        return $view->getCssClass();
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'visca_licom_extension_entity_match_status_description';
    }
}
