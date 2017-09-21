<?php

declare(strict_types=1);

namespace Visca\Bundle\LicomBundle\Matcher\Slug\Fallback;

use Symfony\Component\HttpFoundation\RedirectResponse;
use Visca\Bundle\LicomBundle\Matcher\Slug\CompetitionSlugMatcher;
use Visca\Bundle\LicomBundle\Exception\NoMatchFoundException;
use Visca\Bundle\LicomBundle\Entity\Country;
use Visca\Bundle\LicomBundle\Entity\Competition;

/**
 * Class CompetitionSlugMatcherFallback
 */
class CompetitionSlugMatcherFallbackRedirect extends CompetitionSlugMatcher
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
            'coppa-italia-lega-pro' => 'coppa-italia-serie-c'
        ];
    }

    /**
     * @return Competition|RedirectResponse
     */
    public function matchForFixtures(string $competitionSlug, Country $country)
    {
        return $this->matchOrRedirect($competitionSlug, $country, 'getFixturesRoute');
    }

    public function matchForResults(string $competitionSlug, Country $country)
    {
        return $this->matchOrRedirect($competitionSlug, $country, 'getResultsRoute');
    }

    public function matchForStanding(string $competitionSlug, Country $country)
    {
        return $this->matchOrRedirect($competitionSlug, $country, 'getStandingRoute');
    }

    public function matchForSummary(string $competitionSlug, Country $country)
    {
        return $this->matchOrRedirect($competitionSlug, $country, 'getCompetitionRoute');
    }

    public function matchForTeams(string $competitionSlug, Country $country)
    {
        return $this->matchOrRedirect($competitionSlug, $country, 'getTeamsRoute');
    }

    protected function matchOrRedirect(string $competitionSlug, Country $country, string $urlMethod)
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
     */
    protected function findFallback(string $competitionSlug, Country $country)
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
