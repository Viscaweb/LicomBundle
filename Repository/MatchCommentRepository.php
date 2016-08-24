<?php

namespace Visca\Bundle\LicomBundle\Repository;

use Visca\Bundle\DoctrineBundle\Repository\Abstracts\AbstractEntityRepository;
use Visca\Bundle\LicomBundle\Entity\MatchComment;

/**
 * Class MatchCommentRepository.
 */
class MatchCommentRepository extends AbstractEntityRepository
{
    /**
     * @param int $matchId             match id
     * @param int $localizationProfile localization profile id
     *
     * @throws \Doctrine\ORM\NoResultException
     * @throws \Doctrine\ORM\NonUniqueResultException
     *
     * @return MatchComment[]
     */
    public function findByMatchAndLocalizationProfile(
        $matchId,
        $localizationProfile
    ) {
        $comments = $this
            ->createQueryBuilder('mc')
            ->where('mc.match = :matchId')
            ->andWhere('mc.localization = :localizationProfile')
            ->andWhere('mc.del = :del')
            ->setParameters(
                [
                    'matchId' => $matchId,
                    'localizationProfile' => $localizationProfile,
                    'del' => 'no',
                ]
            )
            ->getQuery()
            ->getResult();

        usort($comments, [$this, 'sortComments']);

        return $comments;
    }

    /**
     * @param MatchComment $comment1
     * @param MatchComment $comment2
     *
     * @return bool
     */
    private function sortComments(
        MatchComment $comment1,
        MatchComment $comment2
    ) {
        $position1 = $this->getCommentPosition($comment1);
        $position2 = $this->getCommentPosition($comment2);

        return $position1 < $position2;
    }

    /**
     * @param MatchComment $comment
     *
     * @return int
     */
    private function getCommentPosition(MatchComment $comment)
    {
        $timeComment = $comment->getTimeElapsed();
        $extraTimeComment = $comment->getTimeElapsedExtra();

        if ($timeComment >= 0) {
            $sortCriteria = [
                $timeComment,
                0,
                $extraTimeComment,
                $comment->getId()
            ];
        } else {
            $sortCriteria = [
                $this->convertNegativeTime($timeComment),
                $this->returnsTrueIfForceAfter($timeComment) ? 1 : -1,
                $extraTimeComment,
                $comment->getId()
            ];
        }

        $position = 0;
        $coefficient = count($sortCriteria);
        foreach ($sortCriteria as $number) {
            $position += $coefficient * $number;
            --$coefficient;
        }

        return $position;
    }

    /**
     * @param $time
     *
     * @return bool
     */
    private function returnsTrueIfForceAfter($time)
    {
        switch ($time) {
            case -4: // After match
                return true;
                break;
            case -3: // Half-time
                return true;
                break;
            default:
                return false;
        }
    }

    /**
     * @param $time
     *
     * @return int
     */
    private function convertNegativeTime($time)
    {
        switch ($time) {
            case -2: // Before match
                return 0;
                break;
            case -4: // After match
                return 120;
                break;
            case -3: // Half-time
                return 45;
                break;
            default:
                return 0;
        }
    }
}
