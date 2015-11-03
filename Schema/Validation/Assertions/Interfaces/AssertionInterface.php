<?php

namespace Visca\Bundle\LicomBundle\Schema\Validation\Assertions\Interfaces;

use SimpleXMLElement;

/**
 * Interface AssertionInterface.
 */
interface AssertionInterface
{
    /**
     * @param SimpleXMLElement $tableElement
     *
     * @return bool
     */
    public function assertValid(SimpleXMLElement $tableElement);
}
