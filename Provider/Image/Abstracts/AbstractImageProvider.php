<?php

namespace Visca\Bundle\LicomViewBundle\Provider\Image\Abstracts;

use Visca\Bundle\MediaBundle\Adapter\Interfaces\AdapterInterface;
use Visca\Bundle\MediaBundle\Factory\MediaFactory;
use Visca\Bundle\MediaBundle\Provider\Path\Abstracts\AbstractImageProvider as MediaBundleAbstractImageProvider;

/**
 * AbstractImageProvider.
 */
abstract class AbstractImageProvider extends MediaBundleAbstractImageProvider
{
    /**
     * @param AdapterInterface $fileAdapter  fileAdapter
     * @param MediaFactory     $mediaFactory mediaFactory
     */
    public function __construct(AdapterInterface $fileAdapter, MediaFactory $mediaFactory)
    {
        parent::__construct($fileAdapter, $mediaFactory);
    }
}
