<?php

namespace Visca\Bundle\LicomBundle\Schema\Validation\Assertions;

use SimpleXMLElement;
use Visca\Bundle\LicomBundle\Schema\Validation\Assertions\Abstracts\AbstractColumnAssertion;

/**
 * Class DelColumnIsNotNullable.
 */
class DelColumnIsNotNullable extends AbstractColumnAssertion
{
    /**
     * {@inheritdoc}
     */
    public function assertValid(SimpleXMLElement $tableElement)
    {
        return $this->assertColumnNotNull($tableElement, 'del');
    }
}
