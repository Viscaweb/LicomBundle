<?php
namespace Visca\Bundle\LicomBundle\Model\Slug;

use Visca\Bundle\LicomBundle\Entity\Participant;

/**
 * Class ParticipantCombinationModel
 */
class ParticipantCombinationModel
{
    /**
     * @var Participant Home Participant
     */
    protected $homeParticipant;

    /**
     * @var Participant Away Participant
     */
    protected $awayParticipant;

    /**
     * @var string Slug
     */
    protected $initialSlug;

    /**
     * ParticipantCombinationModel constructor.
     *
     * @param Participant $homeParticipant Home Participant
     * @param Participant $awayParticipant Away Participant
     * @param string      $initialSlug     Initial slug
     */
    public function __construct(
        Participant $homeParticipant,
        Participant $awayParticipant,
        $initialSlug
    ) {
        $this->homeParticipant = $homeParticipant;
        $this->awayParticipant = $awayParticipant;
        $this->initialSlug = $initialSlug;
    }

    /**
     * @return Participant
     */
    public function getHomeParticipant()
    {
        return $this->homeParticipant;
    }

    /**
     * @return Participant
     */
    public function getAwayParticipant()
    {
        return $this->awayParticipant;
    }

    /**
     * @return string
     */
    public function getInitialSlug()
    {
        return $this->initialSlug;
    }
}
