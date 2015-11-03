<?php

namespace Visca\Bundle\LicomBundle\Entity;

use DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Visca\Bundle\CoreBundle\Entity\Traits\DeletableTrait;
use Visca\Bundle\CoreBundle\Entity\Traits\OptionalDateTimeTrait;
use Visca\Bundle\LicomBundle\Entity\Code\CompetitionStageTypeCode;
use Visca\Bundle\LicomBundle\Entity\Interfaces\EntityWithAuxInterface;
use Visca\Bundle\LicomBundle\Entity\Traits\EntityWithAuxTrait;
use Visca\Bundle\LicomBundle\Entity\Traits\MatchTrait;
use Visca\Bundle\LicomBundle\Factory\MatchFactory;

/**
 * Match.
 *
 * This model is simply the most important of the entire project.
 * All matches are saved in here, whatever the sport or date.
 *
 * This model contains only the mandatory and most used properties.
 * All the extra information (such as the referee name, the stadium name,
 * the number of spectators, etc.) are saved in Match_aux.
 *
 * Quantity of data: Since all the matches will be saved in here, this model usually contains a LARGE amount of rows.
 *
 * @example FC Barcelona - Real Madrid
 * @example France - Canada
 */
class Match implements EntityWithAuxInterface
{
    use OptionalDateTimeTrait;
    use DeletableTrait;
    use EntityWithAuxTrait;
    use MatchTrait;

    const COVERAGE_LIVE = 'live';
    const COVERAGE_COMMENT = 'comment';
    const COVERAGE_LINEUP = 'lineup';

    /**
     * @var int
     */
    private $id;

    /**
     * @var string
     */
    private $name;

    /**
     * @var DateTime
     */
    private $startDate;

    /**
     * @var string|null
     */
    private $coverage;

    /**
     * @var string|null MatchWinnerType
     */
    private $winner;

    /**
     * @var string|null MatchWinnerType
     */
    private $ordinaryTimeWinner;

    /**
     * @var string|null MatchWinnerType
     */
    private $afterShootoutWinner;

    /**
     * @var string|null MatchWinnerType
     */
    private $aggregatedWinner;

    /**
     * @var CompetitionRound|null
     */
    private $competitionRound;

    /**
     * @var CompetitionLeg|null
     */
    private $competitionLeg;

    /**
     * @var MatchStatusDescription
     */
    private $matchStatusDescription;

    /**
     * @var Collection|MatchAux[]
     */
    private $aux;

    /**
     * @var Collection|MatchAuxProfile[]
     */
    private $matchAuxProfile;

    /**
     * @var Collection|MatchParticipant[]
     */
    private $matchParticipant;

    /**
     * @var CompetitionSeasonStage
     */
    private $competitionSeasonStage;

    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->aux = new ArrayCollection();
        $this->matchParticipant = new ArrayCollection();
        $this->matchAuxProfile = new ArrayCollection();
    }

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
     * Set name.
     *
     * @param string $name
     *
     * @return Match
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name.
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set startDate.
     *
     * @param DateTime $startDate
     *
     * @return Match
     */
    public function setStartDate(DateTime $startDate)
    {
        $this->startDate = $startDate;

        return $this;
    }

    /**
     * Get startDate.
     *
     * @return DateTime
     */
    public function getStartDate()
    {
        return $this->startDate;
    }

    /**
     * Set coverage.
     *
     * @param array|null $coverage
     *
     * @return Match
     */
    public function setCoverage(array $coverage = null)
    {
        if (null === $coverage) {
            $this->coverage = null;
        } else {
            $this->coverage = implode(',', $coverage);
        }

        return $this;
    }

    /**
     * Get coverage.
     *
     * @return array|null
     */
    public function getCoverage()
    {
        if (null === $this->coverage) {
            return;
        }

        return explode(',', $this->coverage);
    }

    /**
     * @param string $coverage
     *
     * @return bool
     */
    public function hasCoverage($coverage)
    {
        if (null === $this->coverage) {
            return false;
        }

        return in_array($coverage, explode(',', $this->coverage));
    }

    /**
     * Set winner.
     *
     * @param string|null $winner
     *
     * @return Match
     */
    public function setWinner($winner)
    {
        $this->winner = $winner;

        return $this;
    }

    /**
     * Get winner.
     *
     * @return string|null
     */
    public function getWinner()
    {
        return $this->winner;
    }

    /**
     * @return null|string
     */
    public function getOrdinaryTimeWinner()
    {
        return $this->ordinaryTimeWinner;
    }

    /**
     * @param null|string $ordinaryTimeWinner
     *
     * @return $this
     */
    public function setOrdinaryTimeWinner($ordinaryTimeWinner)
    {
        $this->ordinaryTimeWinner = $ordinaryTimeWinner;

        return $this;
    }

    /**
     * @return null|string
     */
    public function getAfterShootoutWinner()
    {
        return $this->afterShootoutWinner;
    }

    /**
     * @param null|string $afterShootoutWinner
     *
     * @return $this
     */
    public function setAfterShootoutWinner($afterShootoutWinner)
    {
        $this->afterShootoutWinner = $afterShootoutWinner;

        return $this;
    }

    /**
     * Set aggregatedWinner.
     *
     * @param string|null $aggregatedWinner
     *
     * @return Match
     */
    public function setAggregatedWinner($aggregatedWinner)
    {
        $this->aggregatedWinner = $aggregatedWinner;

        return $this;
    }

    /**
     * Get aggregatedWinner.
     *
     * @return string|null
     */
    public function getAggregatedWinner()
    {
        return $this->aggregatedWinner;
    }

    /**
     * Set competitionRound.
     *
     * @param CompetitionRound|null $competitionRound
     *
     * @return Match
     */
    public function setCompetitionRound(
        CompetitionRound $competitionRound = null
    ) {
        $this->competitionRound = $competitionRound;

        return $this;
    }

    /**
     * Get competitionRound.
     *
     * @return CompetitionRound|null
     */
    public function getCompetitionRound()
    {
        return $this->competitionRound;
    }

    /**
     * Set competitionLeg.
     *
     * @param CompetitionLeg|null $competitionLeg
     *
     * @return Match
     */
    public function setCompetitionLeg(CompetitionLeg $competitionLeg = null)
    {
        $this->competitionLeg = $competitionLeg;

        return $this;
    }

    /**
     * Get competitionLeg.
     *
     * @return CompetitionLeg|null
     */
    public function getCompetitionLeg()
    {
        return $this->competitionLeg;
    }

    /**
     * Set matchStatusDescription.
     *
     * @param MatchStatusDescription $matchStatusDescription
     *
     * @return Match
     */
    public function setMatchStatusDescription(
        MatchStatusDescription $matchStatusDescription = null
    ) {
        $this->matchStatusDescription = $matchStatusDescription;

        return $this;
    }

    /**
     * Get matchStatusDescription.
     *
     * @return MatchStatusDescription
     */
    public function getMatchStatusDescription()
    {
        return $this->matchStatusDescription;
    }

    /**
     * Add matchAux.
     *
     * @param MatchAux $matchAux
     *
     * @return Match
     */
    public function addAux(MatchAux $matchAux)
    {
        $this->aux[] = $matchAux;

        return $this;
    }

    /**
     * Remove matchAux.
     *
     * @param MatchAux $matchAux
     */
    public function removeAux(MatchAux $matchAux)
    {
        $this->aux->removeElement($matchAux);
    }

    /**
     * Get matchAux.
     *
     * @return Collection|MatchAux[]
     */
    public function getAux()
    {
        return $this->aux;
    }

    /**
     * Add matchParticipant.
     *
     * @param MatchParticipant $matchParticipant
     *
     * @return Match
     */
    public function addMatchParticipant(
        MatchParticipant $matchParticipant
    ) {
        $this->matchParticipant[] = $matchParticipant;

        return $this;
    }

    /**
     * Remove matchParticipant.
     *
     * @param MatchParticipant $matchParticipant
     */
    public function removeMatchParticipant(
        MatchParticipant $matchParticipant
    ) {
        $this->matchParticipant->removeElement($matchParticipant);
    }

    /**
     * Get matchParticipant.
     *
     * @return Collection|MatchParticipant[]
     */
    public function getMatchParticipant()
    {
        return $this->matchParticipant;
    }

    /**
     * Set competitionSeasonStage.
     *
     * @param CompetitionSeasonStage $competitionSeasonStage
     *
     * @return Match
     */
    public function setCompetitionSeasonStage(
        CompetitionSeasonStage $competitionSeasonStage
    ) {
        $this->competitionSeasonStage = $competitionSeasonStage;

        return $this;
    }

    /**
     * Get competitionSeasonStage.
     *
     * @return CompetitionSeasonStage
     */
    public function getCompetitionSeasonStage()
    {
        return $this->competitionSeasonStage;
    }

    /**
     * @return Match
     */
    public static function create()
    {
        $factory = new MatchFactory();

        return $factory->create();
    }

    /**
     * Add matchAuxProfile.
     *
     * @param MatchAuxProfile $matchAuxProfile
     *
     * @return $this
     */
    public function addMatchAuxProfile(
        MatchAuxProfile $matchAuxProfile
    ) {
        $this->matchAuxProfile[] = $matchAuxProfile;

        return $this;
    }

    /**
     * Remove matchAuxProfile.
     *
     * @param MatchAuxProfile $matchAuxProfile
     */
    public function removeMatchAuxProfile(
        MatchAuxProfile $matchAuxProfile
    ) {
        $this->matchAuxProfile->removeElement($matchAuxProfile);
    }

    /**
     * Get matchAuxProfile.
     *
     * @return Collection|MatchAuxProfile[]
     */
    public function getMatchAuxProfile()
    {
        return $this->matchAuxProfile;
    }

    /**
     * Gets time elapsed.
     */
    public function getTimeElapsed()
    {
        return 53;
    }

    /**
     * Returns true if a any of teams playing in this match has red cards.
     *
     * @return bool
     */
    public function hasRedCardIncidents()
    {
        foreach ($this->getMatchParticipant() as $matchParticipant) {
            if ($matchParticipant->hasIncidentsWithRedCard()) {
                return true;
            }
        }

        return false;
    }

    /**
     * Returns true if the match is currently in progress.
     *
     * @return bool
     */
    public function isLive()
    {
        $categoryLiveCode = MatchStatusDescription::IN_PROGRESS_KEY;
        $matchCategory = $this->getMatchStatusDescription()->getCategory();

        return ($categoryLiveCode == $matchCategory);
    }

    /**
     * Returns true if the match is finished.
     *
     * @return bool
     */
    public function isFinished()
    {
        $categoryFinishedCode = MatchStatusDescription::FINISHED_KEY;
        $matchCategory = $this->getMatchStatusDescription()->getCategory();

        return ($categoryFinishedCode == $matchCategory);
    }

    /**
     * Returns true if the match is a final.
     *
     * @return bool
     */
    public function isFinal()
    {
        $isFinal = false;
        $competitionSeasonStage = $this->getCompetitionSeasonStage();
        $stageTypeCode = $competitionSeasonStage
            ->getCompetitionStage()
            ->getCompetitionStageType1()
            ->getCode();

        if ($stageTypeCode === CompetitionStageTypeCode::FINAL_CODE) {
            // Check if last round
            $competitionRound = $this->getCompetitionRound();
            if ($competitionRound instanceof CompetitionRound) {
                $isFinal = ($competitionRound->getName() == 'final');
            }
        }

        return $isFinal;
    }
}
