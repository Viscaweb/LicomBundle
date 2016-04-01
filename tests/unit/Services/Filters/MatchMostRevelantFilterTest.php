<?php

namespace Tests\Unit\Services\Filters;


use Visca\Bundle\LicomBundle\Entity\Match;
use Visca\Bundle\LicomBundle\Entity\MatchStatusDescription;
use Visca\Bundle\LicomBundle\Exception\NoMatchFoundException;
use Visca\Bundle\LicomBundle\Services\Filters\MatchMostRelevantFilter;
use Visca\Bundle\LicomBundle\Services\Filters\Rules\MatchInProgressRule;

class MatchMostRelevantFilterTest extends \PHPUnit_Framework_TestCase
{

    /** @test */
    public function given_a_collection_of_matches_return_first_in_list_if_any_rule_is_set()
    {
        $trendingMatch = new MatchMostRelevantFilter($filters = []);
        $expectedMatch = (new Match())->setName('foo-vs-bar');
        $this->assertEquals($trendingMatch->filter([$expectedMatch, new Match()]), $expectedMatch);
    }

    /** @test */
    public function given_a_collection_of_matches_return_one_in_live()
    {
        $trendingMatch = new MatchMostRelevantFilter([new MatchInProgressRule()]);
        $expectedMatch = $this->getInLiveMatch();
        $collectionOfMatchesToSearch = $this->getCollectionOfMatchesForInLive();
        $this->assertEquals($trendingMatch->filter($collectionOfMatchesToSearch), $expectedMatch);
    }

    /** @test */
    public function given_a_collection_of_matches_throw_exception_if_any_match_is_provided()
    {
        $trendingMatch = new MatchMostRelevantFilter($filters = []);
        $this->setExpectedException(NoMatchFoundException::class);
        $trendingMatch->filter([]);
    }


    //---[ Helpers ]--------------------------------------------------------------------//

    /**
     * @return Match
     */
    protected function getInLiveMatch()
    {
        return (new Match())
            ->setName('foo-vs-bar')
            ->setMatchStatusDescription(
                $this->createMatchStatusDescriptionWithCategoryName(MatchStatusDescription::IN_PROGRESS_KEY)
            );
    }

    /**
     * @return Match[]
     */
    private function getCollectionOfMatchesForInLive()
    {
        return [
            (new Match())->setName('foo')->setMatchStatusDescription(
                $this->createMatchStatusDescriptionWithCategoryName('bar')
            ),
            (new Match())->setName('bar')->setMatchStatusDescription(
                $this->createMatchStatusDescriptionWithCategoryName('baz')
            ),
            $this->getInLiveMatch(),
        ];
    }

    /**
     * @param string $name
     * @return MatchStatusDescription
     */
    private function createMatchStatusDescriptionWithCategoryName($name)
    {
        return (new MatchStatusDescription())->setCategory($name);
    }

//    /**
//     * @param object $object
//     * @param string $property
//     * @param mixed $value
//     */
//    private function setPrivateProperty($object, $property, $value)
//    {
//        $rClass = new \ReflectionClass($object);
//        $rProperty = $rClass->getProperty($property);
//        $rProperty->setAccessible(true);
//        $rProperty->setValue($object, $value);
//    }
}
