<?php

namespace Visca\Bundle\LicomBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Visca\Bundle\CoreBundle\Entity\Traits\OptionalDateTimeTrait;
use Visca\Bundle\CoreBundle\Entity\Traits\DeletableTrait;
use Visca\Bundle\LicomBundle\Factory\ProfileFactory;

/**
 * Profile.
 *
 * The Profile helps defining all the locales, regions and translations.
 * We are defining 1 Profile for each website installation.
 *
 * Quantity of data: This model contains a static number of rows.
 */
class Profile
{
    use OptionalDateTimeTrait;
    use DeletableTrait;

    /**
     * @var int
     */
    private $id;

    /**
     * @var string
     */
    private $code;

    /**
     * @var string
     */
    private $name;

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
     * @return Profile
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Get code.
     *
     * @return string
     */
    public function getCode()
    {
        return $this->code;
    }

    /**
     * Set code.
     *
     * @param string $code
     *
     * @return Profile
     */
    public function setCode($code)
    {
        $this->code = $code;

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
     * Set name.
     *
     * @param string $name
     *
     * @return Profile
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Add profileTranslationGraph.
     *
     * @param ProfileTranslationGraph $profileTranslationGraph
     *
     * @return Profile
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

    /**
     * @return Profile
     */
    public static function create()
    {
        $factory = new ProfileFactory();

        return $factory->create();
    }
}
