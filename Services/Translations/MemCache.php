<?php

namespace Visca\Bundle\LicomBundle\Services\Translations;

use Doctrine\Common\Cache\Cache;

/**
 * Class MemCache
 */
class MemCache implements Cache
{
    /** @var \Memcached */
    private $memcache;

    /** @var string */
    private $host;

    /** @var int */
    private $port;

    public function __construct($host, $port)
    {
        $this->host = $host;
        $this->port = $port;

//        '%memcached_host%', '%memcached_port%'
        $this->memcache = new \Memcached();
        $this->memcache->addServer($host, $port);

    }

    /**
     * Fetches an entry from the cache.
     *
     * @param string $id The id of the cache entry to fetch.
     *
     * @return mixed The cached data or FALSE, if no cache entry exists for the given id.
     */
    public function fetch($id)
    {
        return $this->memcache->get($id);
    }

    /**
     * Tests if an entry exists in the cache.
     *
     * @param string $id The cache id of the entry to check for.
     *
     * @return boolean TRUE if a cache entry exists for the given cache id, FALSE otherwise.
     */
    public function contains($id)
    {
        return (false !== $this->memcache->get($id));
    }

    /**
     * Puts data into the cache.
     *
     * @param string $id       The cache id.
     * @param mixed  $data     The cache entry/data.
     * @param int    $lifeTime The cache lifetime.
     *                         If != 0, sets a specific lifetime for this cache entry (0 => infinite lifeTime).
     *
     * @return boolean TRUE if the entry was successfully stored in the cache, FALSE otherwise.
     */
    public function save($id, $data, $lifeTime = 0)
    {
        $lifeTime = ($lifeTime > 30 * 24 * 3600) ? time() + $lifeTime : $lifeTime;

        $result = $this->memcache->set($id, $data, (int) $lifeTime);

        return $result;
    }

    /**
     * Deletes a cache entry.
     *
     * @param string $id The cache id.
     *
     * @return boolean TRUE if the cache entry was successfully deleted, FALSE otherwise.
     */
    public function delete($id)
    {
        return $this->memcache->delete($id);
    }

    /**
     * Retrieves cached information from the data store.
     *
     * The server's statistics array has the following values:
     *
     * - <b>hits</b>
     * Number of keys that have been requested and found present.
     *
     * - <b>misses</b>
     * Number of items that have been requested and not found.
     *
     * - <b>uptime</b>
     * Time that the server is running.
     *
     * - <b>memory_usage</b>
     * Memory used by this server to store items.
     *
     * - <b>memory_available</b>
     * Memory allowed to use for storage.
     *
     * @since 2.2
     *
     * @return array|null An associative array with server's statistics if available, NULL otherwise.
     */
    public function getStats()
    {
        $stats   = $this->memcache->getStats();
        $servers = $this->memcache->getServerList();
        $key     = $this->host . ':' . $this->port;
        $stats   = $stats[$key];
        return array(
            Cache::STATS_HITS   => $stats['get_hits'],
            Cache::STATS_MISSES => $stats['get_misses'],
            Cache::STATS_UPTIME => $stats['uptime'],
            Cache::STATS_MEMORY_USAGE     => $stats['bytes'],
            Cache::STATS_MEMORY_AVAILABLE => $stats['limit_maxbytes'],
        );
    }
}
