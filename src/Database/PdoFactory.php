<?php

/**
 * This file is part of JohnCMS Content Management System.
 *
 * @copyright JohnCMS Community
 * @license   https://opensource.org/licenses/GPL-3.0 GPL-3.0
 * @link      https://johncms.com JohnCMS Project
 */

declare(strict_types=1);

namespace Johncms\System\Database;

use LogicException;
use PDO;
use PDOException;
use Psr\Container\ContainerInterface;

class PdoFactory
{
    public function __invoke(ContainerInterface $container): PDO
    {
        $config = $container->has('database')
            ? (array) $container->get('database')
            : [];

        $pdo = new PDO(
            $this->prepareDsn($config),
            $config['db_user'] ?? 'root',
            $config['db_pass'] ?? '',
            [
                PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8mb4'",
                PDO::MYSQL_ATTR_USE_BUFFERED_QUERY,
                PDO::ATTR_EMULATE_PREPARES   => false,
            ]
        );

        return $pdo;
    }

    private function prepareDsn(array $config): string
    {
        if (! empty($config['dsn'])) {
            return $config['dsn'];
        }

        $host = $config['db_host'] ?? 'localhost';
        $port = ! empty($config['port']) ? ';port=' . $config['port'] : '';
        $dbname = $config['db_name'] ?? 'johncms';

        return 'mysql:host=' . $host . $port . ';dbname=' . $dbname . ';charset=utf8mb4';
    }
}
