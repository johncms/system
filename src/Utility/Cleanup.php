<?php

/**
 * This file is part of JohnCMS Content Management System.
 *
 * @copyright JohnCMS Community
 * @license   https://opensource.org/licenses/GPL-3.0 GPL-3.0
 * @link      https://johncms.com JohnCMS Project
 */

declare(strict_types=1);

namespace Johncms\System\Utility;

use PDO;

class Cleanup
{
    /** @var PDO */
    private $pdo;

    /** @var string */
    private $cacheFile = 'system-cleanup.cache';

    public function __construct(PDO $pdo, int $lifeFime = 86400)
    {
        $this->pdo = $pdo;
        $cache = CACHE_PATH . $this->cacheFile;

        if (! file_exists($cache) || filemtime($cache) < (time() - $lifeFime)) {
            $this->cleanupTable('cms_sessions', 'lastdate', time() - 86400);
            $this->cleanupTable('cms_users_iphistory', 'time', time() - 7776000);

            file_put_contents($cache, time());
        }
    }

    private function cleanupTable(string $table, string $timestampField, int $condition): void
    {
        $this->pdo->exec('LOCK TABLE `' . $table . '` WRITE');
        $this->pdo->exec('DELETE FROM `' . $table . '` WHERE `' . $timestampField . '` < ' . $condition);
        $this->pdo->query('OPTIMIZE TABLE `' . $table . '`');
        $this->pdo->exec('UNLOCK TABLES');
    }
}
