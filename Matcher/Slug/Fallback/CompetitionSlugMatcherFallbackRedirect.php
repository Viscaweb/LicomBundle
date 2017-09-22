<?php

namespace Visca\Bundle\LicomBundle\Matcher\Slug\Fallback;

use Symfony\Component\HttpFoundation\RedirectResponse;
use Visca\Bundle\LicomBundle\Matcher\Slug\CompetitionSlugMatcher;
use Visca\Bundle\LicomBundle\Exception\NoMatchFoundException;
use Visca\Bundle\LicomBundle\Entity\Country;
use Visca\Bundle\LicomBundle\Entity\Competition;
use Visca\Bundle\SportBundle\Service\CompetitionGetRelatedRoutes;

/**
 * Class CompetitionSlugMatcherFallback.
 */
class CompetitionSlugMatcherFallbackRedirect
{
    /** @var CompetitionSlugMatcher */
    private $slugMatcher;

    /** @var array */
    private $map;

    /**
     * CompetitionSlugMatcherFallback constructor.
     *
     * @param CompetitionSlugMatcher $slugMatcher
     * @param array                  $map
     */
    public function __construct(CompetitionSlugMatcher $slugMatcher, CompetitionGetRelatedRoutes $competitionRoutes)
    {
        $this->slugMatcher = $slugMatcher;
        $this->competitionRoutes = $competitionRoutes;
        $this->map = [
            'lega-pro-grp-a' => 'serie-c-grp-a',
            'lega-pro-grp-b' => 'serie-c-grp-b',
            'lega-pro-grp-c' => 'serie-c-grp-c',
            'coppa-italia-lega-pro' => 'coppa-italia-serie-c',
        ];
    }

    /**
     *
     * @param string  $competitionSlug
     * @param Country $country
     *
     * @return RedirectResponse|Competition
     */
    public function matchForFixtures($competitionSlug, Country $country)
    {
        return $this->matchOrRedirect($competitionSlug, $country, 'getFixturesRoute');
    }

    /**
     * @param string  $competitionSlug
     * @param Country $country
     *
     * @return RedirectResponse|Competition
     */
    public function matchForResults($competitionSlug, Country $country)
    {
        return $this->matchOrRedirect($competitionSlug, $country, 'getResultsRoute');
    }

    /**
     * @param string  $competitionSlug
     * @param Country $country
     *
     * @return RedirectResponse|Competition
     */
    public function matchForStanding($competitionSlug, Country $country)
    {
        return $this->matchOrRedirect($competitionSlug, $country, 'getStandingRoute');
    }

    /**
     * @param string  $competitionSlug
     * @param Country $country
     *
     * @return RedirectResponse|Competition
     */
    public function matchForSummary($competitionSlug, Country $country)
    {
        return $this->matchOrRedirect($competitionSlug, $country, 'getCompetitionRoute');
    }

    /**
     * @param string  $competitionSlug
     * @param Country $country
     *
     * @return RedirectResponse|Competition
     */
    public function matchForTeams($competitionSlug, Country $country)
    {
        return $this->matchOrRedirect($competitionSlug, $country, 'getTeamsRoute');
    }

    /**
     * @param string  $competitionSlug
     * @param Country $country
     * @param string  $urlMethod
     *
     * @return RedirectResponse|Competition
     */
    protected function matchOrRedirect($competitionSlug, Country $country, $urlMethod)
    {
        try {
            $competition = $this->slugMatcher->match($competitionSlug, $country);
        } catch (NoMatchFoundException $e) {
            $competitionFallback = $this->findFallback($competitionSlug, $country);
            if ($competitionFallback instanceof Competition) {
                $this->competitionRoutes->setCompetition($competitionFallback);
                $url = call_user_func([$this->competitionRoutes, $urlMethod]);

                return new RedirectResponse($url);
            }
        }

        return $competition;
    }


    /**
     * @throw NoMatchFoundException
     *
     * @param string  $competitionSlug
     * @param Country $country
     *
     * @return Competition
     * @throws NoMatchFoundException
     */
    protected function findFallback($competitionSlug, Country $country)
    {
        if (isset($this->map[$competitionSlug])) {
            $competitionSlug = $this->map[$competitionSlug];

            return $this->slugMatcher->match($competitionSlug, $country);
        }

        $message = "Unable to find any Competition with the given slug ($competitionSlug given).";
        $this->logger->debug($message);
        throw new NoMatchFoundException($e);
    }
}
