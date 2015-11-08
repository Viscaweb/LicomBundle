<?php

namespace Visca\Bundle\LicomBundle\Services\Chain;

use InvalidArgumentException;
use OutOfRangeException;
use Visca\Bundle\LicomBundle\Formatter\Odds\Interfaces\OddsFormatterInterface;

/**
 * Chain containing all the odds formatter.
 */
class OddsFormatterChain
{
    /**
     * @var OddsFormatterInterface[]
     */
    private $oddsFormatter;

    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->oddsFormatter = [];
    }

    /**
     * Attach an entity factory to the chain.
     *
     * @param string $id      Service ID
     * @param object $service Service object
     *
     * @throws InvalidArgumentException
     */
    public function attach($id, $service)
    {
        if (!is_string($id)) {
            throw new InvalidArgumentException(
                sprintf(
                    'Invalid id. A string is expected but "%s" was given.',
                    gettype($id)
                )
            );
        }

        if (!$service instanceof OddsFormatterInterface) {
            throw new InvalidArgumentException(
                sprintf(
                    'The given service must implement OddsFormatterInterface. ("%s" given)',
                    get_class($service)
                )
            );
        }

        $this->oddsFormatter[$id] = $service;
    }

    /**
     * Detach a entityFactory from the chain.
     *
     * @param string $id Service ID
     */
    public function detach($id)
    {
        if (!is_string($id)) {
            throw new InvalidArgumentException(
                sprintf(
                    'Invalid id. A string is expected but "%s" was given.',
                    gettype($id)
                )
            );
        }

        if (isset($this->oddsFormatter[$id])) {
            unset($this->oddsFormatter[$id]);
        } else {
            throw new OutOfRangeException(
                sprintf(
                    'There are no attached formatter with the id "%s".',
                    gettype($id)
                )
            );
        }
    }

    /**
     * Get an odds formatter.
     *
     * @param string $id Service ID
     *
     * @return null|OddsFormatterInterface
     *
     * @throws InvalidArgumentException
     */
    public function get($id)
    {
        if (!is_string($id)) {
            throw new InvalidArgumentException(
                sprintf(
                    'Invalid id. A string is expected but "%s" was given.',
                    gettype($id)
                )
            );
        }

        return isset($this->oddsFormatter[$id])
            ? $this->oddsFormatter[$id]
            : null;
    }

    /**
     * @return OddsFormatterInterface[]
     */
    public function all()
    {
        return $this->oddsFormatter;
    }
}
