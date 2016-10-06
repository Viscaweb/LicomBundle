<?php

namespace Visca\Bundle\LicomBundle\Services\Translations;

use Doctrine\Common\Cache\Cache;
use Doctrine\DBAL\Connection;

/**
 * Class MysqlCache.
 */
class MysqlCache implements Cache
{
    /** @var Connection */
    protected $dbal;

    /**
     * @var bool Inserts data in bulks of X.
     */
    protected $bulkInsert;

    /** @var array */
    protected $bulkCache;

    /**
     * MysqlCache constructor.
     *
     * @param Connection $dbal
     */
    public function __construct(Connection $dbal)
    {
        $this->dbal = $dbal;
        $this->bulkInsert = 500;
    }

    private function getTable()
    {
        return 'visca_translations';
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
        $this->batchInsert(true);

        $sql = 'SELECT value FROM '.$this->getTable().' WHERE `key`=:key';
        $stmt = $this->dbal->prepare($sql);
        $stmt->bindValue('key', $id);

        $stmt->execute();

        $result = $stmt->fetch();

        return $result['value'];
    }

    /**
     * Tests if an entry exists in the cache.
     *
     * @param string $id The cache id of the entry to check for.
     *
     * @return bool TRUE if a cache entry exists for the given cache id, FALSE otherwise.
     */
    public function contains($id)
    {
        $value = $this->fetch($id);

        return (count($value) > 0);
    }

    /**
     * Puts data into the cache.
     *
     * @param string $id       The cache id.
     * @param mixed  $data     The cache entry/data.
     * @param int    $lifeTime The cache lifetime.
     *                         If != 0, sets a specific lifetime for this cache entry (0 => infinite lifeTime).
     *
     * @return bool TRUE if the entry was successfully stored in the cache, FALSE otherwise.
     */
    public function save($id, $data, $lifeTime = 0)
    {
        $executeStmt = true;
        $result = true;

        if ($this->bulkInsert) {
            $this->bulkCache[] = ['key' => $id, 'value' => $data];
            $result = $this->batchInsert();
        } else {
            $result = $this->insert($id, $data);
        }

        return $result;
    }

    /**
     * Deletes a cache entry.
     *
     * @param string $id The cache id.
     *
     * @return bool TRUE if the cache entry was successfully deleted, FALSE otherwise.
     */
    public function delete($id)
    {
        $sql = 'DELETE FROM `'.$this->getTable().'` WHERE `key`=:key';
        $stmt = $this->dbal->prepare($sql);
        $stmt->execute();

        return true;
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
        return [];
    }

    /**
     * @return bool
     */
    private function batchInsert($force = false)
    {
        $result = false;

        if (($force && count($this->bulkCache)) || count($this->bulkCache) == $this->bulkInsert) {
            $executeStmt = true;

            $pendantValues = [];
            foreach ($this->bulkCache as $pendant) {
                $pendantValues[] = '('.$this->dbal->quote($pendant['key']).', '.$this->dbal->quote($pendant['value']).')';
            }
            $sql = 'INSERT INTO `%s` (`%s`) VALUES %s ON DUPLICATE KEY UPDATE `key`=VALUES(`key`), `value`=VALUES(`value`)';

            $stmt = $this->dbal->prepare(
                sprintf(
                    $sql,
                    $this->getTable(),
                    implode('`, `', ['key', 'value']),
                    implode(', ', $pendantValues)
                )
            );

            try {
                $result = $stmt->execute();
            } catch (\Exception $e) {
                $result = false;
            }

            $this->bulkCache = [];
        }

        return $result;
    }

    /**
     * @param string $id
     * @param string $data
     *
     * @return bool
     */
    private function insert($id, $data)
    {
        $sql = 'INSERT INTO `%s` (`%s`) VALUES (%s) ON DUPLICATE KEY UPDATE %s';
        $stmt = $this->dbal->prepare(
            sprintf(
                $sql,
                $this->getTable(),
                implode('`, `', ['key', 'value']),
                '`key`=:key, `value`=:value',
                '`key`=:key, `value`=:value'
            )
        );

        $stmt->bindValue('key', $id);
        $stmt->bindValue('value', $data);

        try {
            $result = $stmt->execute();
        } catch (\Exception $e) {
            $result = false;
        }

        return $result;
    }
}
