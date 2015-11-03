<?php

namespace Visca\Bundle\LicomBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Visca\Bundle\LicomBundle\Entity\Traits\GraphLabelTrait;

/**
 * ProfileTranslationGraphLabel.
 */
class ProfileTranslationGraphLabel
{
    use GraphLabelTrait;

    /**
     * @var int
     */
    private $id;

    /**
     * @var Collection
     */
    private $profileTranslationGraph;

    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->profileTranslationGraph = new ArrayCollection();
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
     * Set id.
     *
     * @param int $id
     *
     * @return ProfileTranslationGraphLabel
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Add profileTranslationGraph.
     *
     * @param ProfileTranslationGraph $profileTranslationGraph
     *
     * @return ProfileTranslationGraphLabel
     */
    public function addProfileTranslationGraph(
        ProfileTranslationGraph $profileTranslationGraph
    ) {
        $this->profileTranslationGraph[] = $profileTranslationGraph;

        return $this;
    }

    /**
     * Remove profileTranslationGraph.
     *
     * @param ProfileTranslationGraph $profileTranslationGraph
     */
    public function removeProfileTranslationGraph(
        ProfileTranslationGraph $profileTranslationGraph
    ) {
        $this->profileTranslationGraph->removeElement($profileTranslationGraph);
    }

    /**
     * Get profileTranslationGraph.
     *
     * @return Collection
     */
    public function getProfileTranslationGraph()
    {
        return $this->profileTranslationGraph;
    }
}
