<?php

namespace Visca\Bundle\LicomBundle\Schema;

use Exception;
use SimpleXMLElement;
use Symfony\Component\Process\Process;

/**
 * Load the schema.
 */
class Loader
{
    /**
     * @param string $host
     * @param string $user
     * @param string $password
     * @param string $database
     *
     * @return SimpleXMLElement
     */
    public function load($host, $user, $password, $database)
    {
        $command = $this->getCommand($host, $user, $password, $database);
        $process = new Process($command);
        $process->run();

        $xmlContent = $process->getOutput();
        $xmlElement = simplexml_load_string($xmlContent);

        if (!($xmlElement instanceof SimpleXMLElement)) {
            throw new Exception('Invalid xml data');
        }

        return $xmlElement;
    }

    /**
     * @param string $host
     * @param string $user
     * @param string $password
     * @param string $database
     *
     * @return string
     */
    private function getCommand($host, $user, $password, $database)
    {
        if (strlen($password) > 0) {
            $command = sprintf(
                'mysqldump --xml -h %s -u %s -p%s %s',
                $host,
                $user,
                $password,
                $database
            );
        } else {
            $command = sprintf(
                'mysqldump --xml -h %s -u %s %s',
                $host,
                $user,
                $database
            );
        }

        return $command;
    }
}
