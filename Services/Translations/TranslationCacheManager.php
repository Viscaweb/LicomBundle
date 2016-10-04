<?php

namespace Visca\Bundle\LicomBundle\Services\Translations;

use Doctrine\Common\Cache\Cache;
use Visca\Bundle\LicomBundle\Exception\NoTranslationFoundException;

/**
 * Class TranslationCacheManager.
 */
class TranslationCacheManager
{
    /**
     * @var Cache
     */
    protected $cache;

    /**
     * @var int
     */
    protected $profile;

    /**
     * @var string
     */
    protected $entity;

    /**
     * @param Cache  $cache   Cache
     * @param string $profile Profile
     */
    public function __construct(Cache $cache, $profile)
    {
        $this->cache = $cache;
        $this->profile = $profile;
    }

    /**
     * @param string $entity Entity
     */
    public function setEntity($entity)
    {
        $this->entity = $entity;
    }

    /**
     * @param int    $id       ID
     * @param int    $profile  Profile
     * @param int    $property Property
     * @param string $data     Data
     *
     * @return bool
     */
    public function save($id, $profile, $property, $data)
    {
        $key = $this->getCacheKey($id, $profile, $property);

        $result = $this->cache->save($key, $data);
        
        return $result;
    }

    public function finish()
    {
        $this->cache->fetch(null);
    }

    /**
     * @param int $id       ID
     * @param int $profile  Profile
     * @param int $property Property
     *
     * @return bool
     */
    public function delete($id, $profile, $property)
    {
        $key = $this->getCacheKey($id, $profile, $property);

        return $this->cache->delete($key);
    }

    /**
     * @param int $id       ID
     * @param int $property Property
     *
     * @throws NoTranslationFoundException
     *
     * @return mixed
     */
    public function fetch($id, $property)
    {
        $key = $this->getCacheKey($id, $this->profile, $property);
        $result = $this->cache->fetch($key);

        if (!$result) {
            throw new NoTranslationFoundException();
        }

        return $result;
    }

    /**
     * @return array|null
     */
    public function getStats()
    {
        return $this->cache->getStats();
    }

    /**
     * @param int $id
     * @param int $profile
     * @param int $property
     *
     * @return string
     */
    private function getCacheKey($id, $profile, $property)
    {
        return sprintf(
            'translations-cache:entity-%d:id-%d:profile-%d:property-%d',
            $this->entity,
            $id,
            $profile,
            $property
        );
    }
}
