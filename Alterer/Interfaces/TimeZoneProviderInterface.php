<?php
namespace Visca\Bundle\LicomBundle\Alterer\Interfaces;

/**
 * Interface TimeZoneProviderInterface
 */
interface TimeZoneProviderInterface
{
    /**
     * @return string
     */
    public function getTimezone();
}
