<?php

namespace Visca\Bundle\LicomBundle\ORM;

use Doctrine\ORM\QueryBuilder;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Query\Expr\Join;

/**
 * Class MatchQueryBuilder.
 */
class MatchQueryBuilder extends QueryBuilder
{
    /**
     * @var string
     */
    private $entityName;

    /**
     * @var string
     */
    private $alias;

    /**
     * @var bool Controls wether we select all columns for each entity,
     *           or we select only those really used.
     */
    private $reducedColumnSet;

    /**
     * @var bool Was the MatchParticipant Join optimized?
     */
    private $matchParticipantJoinOptimized;

    /**
     * {@inheritdoc}
     */
    public function __construct(EntityManagerInterface $em, $entityName)
    {
        parent::__construct($em);
        $this->entityName = $entityName;
    }

    /**
     * @param bool $reducedColumnSet
     *
     * @return $this
     */
    public function setReducedColumnSet($reducedColumnSet)
    {
        $this->reducedColumnSet = $reducedColumnSet;

        return $this;
    }

    /**
     * @param string $alias   Alias for the from
     * @param string $indexBy The index for the from.
     *
     * @return $this
     */
    public function prepareQuery($alias, $indexBy = null)
    {
        $this->alias = $alias;
        $columnsSelection = $alias;
        if ($this->reducedColumnSet) {
            $columnsSelection = 'partial '.$alias.'.{id, startDate, coverage, winner, competitionRound, competitionLeg, matchStatusDescription, competitionSeasonStage, mostRelevant}';
        }

        $this
            ->select($columnsSelection)
            ->from($this->entityName, $alias, $indexBy);

        return $this;
    }

    /**
     * @param int  $numberOfParticipants          Number of participants we want to join to.
     * @param int  $numberOfMandatoryParticipants Number of mandatory participants we need.
     * @param bool $optimizeJoin
     *
     * @return $this
     */
    public function joinMatchParticipant($optimizeJoin = false)
    {
        $this->matchParticipantJoinOptimized = $optimizeJoin;
        if ($optimizeJoin) {
            if ($this->reducedColumnSet) {
                $mpColumns = "partial mp1.{id, number}";
                $mp2Columns = "partial mp2.{id, number}";
                $pColumns = "partial p1.{id, name}";
                $p2Columns = "partial p2.{id, name}";
            } else {
                $mpColumns = "mp1";
                $mp2Columns = "mp2";
                $pColumns = "p1";
                $p2Columns = "p2";
            }

            $this
                ->addSelect($mpColumns, $mp2Columns, $pColumns, $p2Columns)
                ->join("$this->alias.matchParticipant", "mp1", Join::WITH, 'mp1.number = 1')
                ->join("$this->alias.matchParticipant", "mp2", Join::WITH, 'mp2.number = 2')
                ->join("mp1.participant", "p1")
                ->join("mp2.participant", "p2");
        } else {
            $this
                ->addSelect("mp", "p")
                ->leftJoin("$this->alias.matchParticipant", 'mp')
                ->join("mp.participant", 'p');
        }

        return $this;
    }

    /**
     * @param int  $numberOfParticipants          Number of participants we want to join to.
     * @param int  $numberOfMandatoryParticipants Number of mandatory participants we need.
     * @param bool $optimizeJoin
     *
     * @return $this
     */
    public function joinMatchParticipantSingleJoin($optimizeJoin = false)
    {
        $this->matchParticipantJoinOptimized = $optimizeJoin;

        if ($optimizeJoin) {
            $this
                ->addSelect("partial mp.{id, number}", "partial p.{id, name}")
                ->join("$this->alias.matchParticipant", "mp")
                ->join("mp.participant", "p");
        } else {
            $this
                ->addSelect("mp", "p")
                ->leftJoin("$this->alias.matchParticipant", 'mp')
                ->join("mp.participant", 'p');
        }

        return $this;
    }


    /**
     * @return $this
     */
    public function joinCompetition()
    {
        $this
            ->leftJoin(
                'm.competitionSeasonStage',
                'css'
            )
            ->leftJoin(
                'css.competitionSeason',
                'cs'
            )
            ->leftJoin(
                'cs.competition',
                'c'
            );

        return $this;
    }

    /**
     * @param int[] $optimizeMatchResultTypeCodes
     *
     * @return $this
     */
    public function joinMatchResult(array $optimizeMatchResultTypeCodes = [])
    {
        if (count($optimizeMatchResultTypeCodes) > 0) {
            $total = 1;
            if ($this->matchParticipantJoinOptimized) {
                $total = 2;
            }

            for ($i = 0; $i < $total; ++$i) {
                $postfix = $total === 0 ? '' : ($i + 1);

                foreach ($optimizeMatchResultTypeCodes as $j => $matchResultTypeCode) {
                    $resultAlias = 'result'.$j.'_'.$postfix;
                    $this->addSelect('partial '.$resultAlias.'.{id, value, matchResultType}');
                    $this->leftJoin(
                        'mp'.$postfix.'.matchResult',
                        $resultAlias,
                        Join::WITH,
                        $resultAlias.'.matchResultType ='.$matchResultTypeCode
                    );
                }
            }
        }

        return $this;
    }

    /**
     * Like joinMatchResultSimple.
     * The difference is this interprets only one join has been done with MatchParticipant.
     *
     * @param array $optimizeMatchResultTypeCodes
     *
     * @return $this
     */
    public function joinMatchResultSingleJoin(array $optimizeMatchResultTypeCodes = [])
    {
        if (count($optimizeMatchResultTypeCodes) > 0) {
            $total = 1;
            if ($this->matchParticipantJoinOptimized) {
                $total = 2;
            }

            for ($i = 0; $i < $total; ++$i) {
                $postfix = $total === 0 ? '' : ($i + 1);

                foreach ($optimizeMatchResultTypeCodes as $j => $matchResultTypeCode) {
                    $resultAlias = 'result'.$j.'_'.$postfix;
                    $this->addSelect('partial '.$resultAlias.'.{id, value, matchResultType}');
                    $this->leftJoin(
                        'mp.matchResult',
                        $resultAlias,
                        Join::WITH,
                        $resultAlias.'.matchResultType ='.$matchResultTypeCode
                    );
                }
            }
        }

        return $this;
    }

    /**
     * @param int[] $optimizeMatchAuxTypeCodes
     *
     * @return $this
     */
    public function joinMatchAux(array $optimizeMatchAuxTypeCodes = [])
    {
        if (count($optimizeMatchAuxTypeCodes) > 0) {
            foreach ($optimizeMatchAuxTypeCodes as $i => $matchAuxTypeCode) {
                $prefix = ($i + 1);
                $this->addSelect('aux'.$prefix);
                $this->leftJoin(
                    "$this->alias.aux",
                    "aux".$prefix,
                    Join::WITH,
                    'aux'.$prefix.'.type = :aux'.$prefix
                )
                    ->setParameter('aux'.$prefix, $matchAuxTypeCode);
            }

            $this
                ->addSelect('auxProfile')
                ->leftJoin("$this->alias.matchAuxProfile", "auxProfile");
        } else {
            $this
                ->addSelect('aux', 'auxProfile')
                ->leftJoin("$this->alias.aux", 'aux')
                ->leftJoin("$this->alias.matchAuxProfile", "auxProfile");
        }

        return $this;
    }
}
