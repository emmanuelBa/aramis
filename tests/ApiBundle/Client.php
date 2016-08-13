<?php

namespace Tests\ApiBundle;

use Symfony\Bundle\FrameworkBundle\Client as BaseClient;

/**
 * Test client.
 */
class Client extends BaseClient
{
    static protected $connection;
    protected $requested;

    protected function doRequest($request)
    {
        if ($this->requested) {
            $this->kernel->shutdown();
            $this->kernel->boot();
        }

        $this->injectConnection();
        $this->requested = true;

        return $this->kernel->handle($request);
    }

    protected function injectConnection()
    {
        if (null === self::$connection) {
            self::$connection = $this->getContainer()->get('doctrine.dbal.default_connection');
        } else {
            if (! $this->requested) {
                if (self::$connection->isTransactionActive()) {
                    self::$connection->rollback();
                }
            }
            $this->getContainer()->set('doctrine.dbal.default_connection', self::$connection);
        }

        if (! $this->requested) {
            self::$connection->beginTransaction();
        }
    }

}