<?php

namespace Tests\Unit\Services\Filters;


use Visca\Bundle\LicomBundle\Entity\Match;
use Visca\Bundle\LicomBundle\Entity\MatchStatusDescription;
use Visca\Bundle\LicomBundle\Exception\NoMatchFoundException;
use Visca\Bundle\LicomBundle\Services\Filters\MatchMostRelevantFilter;
use Visca\Bundle\LicomBundle\Services\Filters\Rules\MatchInProgressRule;
use Visca\Bundle\LicomBundle\Services\Filters\Rules\MatchLastPlayedRule;
use Visca\Bundle\LicomBundle\Services\Filters\Rules\MatchNextToComeRule;

class MatchMostRelevantFilterTest extends \PHPUnit_Framework_TestCase
{

    /** @test */
    public function given_a_collection_of_matches_return_first_in_list_if_no_one_rule_is_set()
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
    public function given_a_collection_of_matches_return_one_match_played_in_the_last_four_days()
    {
        $trendingMatch = new MatchMostRelevantFilter([new MatchLastPlayedRule(4)]);
        $expectedMatch = $this->getLastPlayedMatch();
        $collectionOfMatchesToSearch = $this->getCollectionOfMatchesForLastPlayed();
        $this->assertEquals($trendingMatch->filter($collectionOfMatchesToSearch), $expectedMatch);
    }


    /** @test */
    public function given_a_collection_of_matches_return_one_match_that_is_going_to_be_played_in_coming_three_days()
    {
        $trendingMatch = new MatchMostRelevantFilter([new MatchNextToComeRule(3)]);
        $expectedMatch = $this->getNextToComePlayedMatch();
        $collectionOfMatchesToSearch = $this->getCollectionOfMatchesForNextToCome();
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
        return $this->getCollectionOfMatchesForInLive()[2];
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
            (new Match())->setName('foo-vs-bar')->setMatchStatusDescription(
                $this->createMatchStatusDescriptionWithCategoryName(MatchStatusDescription::IN_PROGRESS_KEY)
            ),
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

    /**
     * @return Match
     */
    private function getLastPlayedMatch()
    {
        return $this->getCollectionOfMatchesForLastPlayed()[2];
    }

    /**
     * @return Match
     */
    private function getNextToComePlayedMatch()
    {
        return $this->getCollectionOfMatchesForNextToCome()[2];
    }

    /**
     * @return Match[]
     */
    private function getCollectionOfMatchesForLastPlayed()
    {
        return [
            $this->setPrivateProperty(new Match(), 'id', 1)->setName('foo-vs-bar')->setMatchStatusDescription(
                $this->createMatchStatusDescriptionWithCategoryName(MatchStatusDescription::FINISHED_KEY)
            )->setStartDate(new \DateTime("-15 days")),
            $this->setPrivateProperty(new Match(), 'id', 2)->setName('foo-vs-bar')->setMatchStatusDescription(
                $this->createMatchStatusDescriptionWithCategoryName(MatchStatusDescription::FINISHED_KEY)
            )->setStartDate(new \DateTime("-10 days")),
            $this->setPrivateProperty(new Match(), 'id', 3)->setName('foo-vs-bar')->setMatchStatusDescription(
                $this->createMatchStatusDescriptionWithCategoryName(MatchStatusDescription::FINISHED_KEY)
            )->setStartDate(new \DateTime("-3 days")),
            $this->setPrivateProperty(new Match(), 'id', 4)->setName('foo-vs-bar')->setMatchStatusDescription(
                $this->createMatchStatusDescriptionWithCategoryName(MatchStatusDescription::FINISHED_KEY)
            )->setStartDate(new \DateTime("-5 days")),
        ];
    }

    /**
     * @return Match[]
     */
    private function getCollectionOfMatchesForNextToCome()
    {
        return [
            $this->setPrivateProperty(new Match(), 'id', 1)->setName('foo-vs-bar')->setMatchStatusDescription(
                $this->createMatchStatusDescriptionWithCategoryName('to-come')
            )->setStartDate(new \DateTime("15 day")),
            $this->setPrivateProperty(new Match(), 'id', 2)->setName('foo-vs-bar')->setMatchStatusDescription(
                $this->createMatchStatusDescriptionWithCategoryName('to-come')
            )->setStartDate(new \DateTime("10 day")),
            $this->setPrivateProperty(new Match(), 'id', 3)->setName('foo-vs-bar')->setMatchStatusDescription(
                $this->createMatchStatusDescriptionWithCategoryName('to-come')
            )->setStartDate(new \DateTime("3 day")),
            $this->setPrivateProperty(new Match(), 'id', 4)->setName('foo-vs-bar')->setMatchStatusDescription(
                $this->createMatchStatusDescriptionWithCategoryName('to-come')
            )->setStartDate(new \DateTime("5 day")),
        ];
    }

    /**
     * @param object $object
     * @param string $property
     * @param mixed $value
     *
     * @return object
     */
    private function setPrivateProperty($object, $property, $value)
    {
        $rClass = new \ReflectionClass($object);
        $rProperty = $rClass->getProperty($property);
        $rProperty->setAccessible(true);
        $rProperty->setValue($object, $value);

        return $object;
    }
}
