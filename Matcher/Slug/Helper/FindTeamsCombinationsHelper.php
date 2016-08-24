<?php

namespace Visca\Bundle\LicomBundle\Matcher\Slug\Helper;

/**
 * Class FindTeamsCombinationsHelper.
 *
 * This class receive a $teamSlug such as: 'fc-barcelona-real-madrid'
 *
 * It will calculate all the existing combinations:
 *  - 'fc-barcelona-real' + 'madrid'
 *  - 'fc-barcelona' + 'real-madrid'
 *  - 'fc' + 'barcelona-real-madrid'
 */
class FindTeamsCombinationsHelper
{
    /**
     * @param string $teamSlug Team Slugs
     *
     * @return array[]
     */
    public function findCombinations($teamSlug)
    {
        $matchSlugSlices = explode('-', $teamSlug);

        $allCombinations = [];
        for ($index = 0; $index < count($matchSlugSlices) - 1; ++$index) {
            $homeCombinationParts = [];
            $awayCombinationParts = [];
            foreach ($matchSlugSlices as $sliceIndex => $slice) {
                if ($sliceIndex > $index) {
                    $awayCombinationParts[] = $slice;
                } else {
                    $homeCombinationParts[] = $slice;
                }
            }
            $allCombinations[] = [
                implode('-', ($homeCombinationParts)),
                implode('-', ($awayCombinationParts)),
            ];
        }

        return $allCombinations;
    }
}
