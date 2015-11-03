<?php

namespace Visca\Bundle\LicomBundle\Entity;

use Visca\Bundle\LicomBundle\Entity\Traits\GraphLabelTrait;

/**
 * LocalizationTranslationGraphLabel.
 */
class LocalizationTranslationGraphLabel
{
    use GraphLabelTrait;

    /**
     * @var int
     */
    private $id;

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
     * @return LocalizationTranslationGraphLabel
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }
}