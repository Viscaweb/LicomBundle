<?php

namespace Visca\Bundle\LicomBundle\Schema\Validation\Assertions;

use SimpleXMLElement;
use Visca\Bundle\LicomBundle\Schema\Validation\Assertions\Abstracts\AbstractColumnAssertion;

/**
 * Class DelColumnDefaultValueIsNo.
 */
class DelColumnDefaultValueIsNo extends AbstractColumnAssertion
{
    /**
     * {@inheritdoc}
     */
    public function assertValid(SimpleXMLElement $tableElement)
    {
        return $this->assertColumnDefaultEqual($tableElement, 'del', 'no');
    }
}
