<?php

namespace Visca\Bundle\LicomBundle\Cache;

use Doctrine\DBAL\Types\DateTimeType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpKernel\CacheWarmer\CacheWarmer;

/**
 * Class UTCDateFieldsWarmer
 */
final class UTCDateFieldsWarmer extends CacheWarmer
{
    const FILENAME = 'licom.model_utc_date_fields.php';

    /**
     * @var EntityManagerInterface Entity Manager
     */
    protected $licomEntityManager;

    /**
     * UTCDateFieldsWarmer constructor.
     *
     * @param EntityManagerInterface $entityManager Licom Entity Manager
     */
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->licomEntityManager = $entityManager;
    }

    /**
     * Warms up the cache.
     *
     * @param string $cacheDir The cache directory
     */
    public function warmUp($cacheDir)
    {
        $dateTimeFields = [];

        $licomTables = $this
            ->licomEntityManager
            ->getConnection()
            ->getSchemaManager()
            ->listTables();

        foreach ($licomTables as $table) {
            $tableName = $table->getName();
            $tableColumns = $table->getColumns();
            foreach ($tableColumns as $column) {
                if (!($column->getType() instanceof DateTimeType)) {
                    continue;
                }

                if (!isset($dateTimeFields[$tableName])) {
                    $dateTimeFields[$tableName] = [];
                }
                $dateTimeFields[$tableName][] = $column->getName();
            }
        }

        $this->writeCacheFile(
            $cacheDir.'/'.(self::FILENAME),
            sprintf('<?php return %s;', var_export($dateTimeFields, true))
        );
    }

    /**
     * We need to calculate the date fields to be altered.
     * This won't be done on demand, it has to be pre-calculated.
     *
     * @return bool true
     */
    public function isOptional()
    {
        return false;
    }
}
