<?php

/**
 * This file is part of JohnCMS Content Management System.
 *
 * @copyright JohnCMS Community
 * @license   https://opensource.org/licenses/GPL-3.0 GPL-3.0
 * @link      https://johncms.com JohnCMS Project
 */

declare(strict_types=1);

namespace Test\Support;

use PDO;
use PDOException;
use PHPUnit\Framework\TestCase;

class DatabaseTestCase extends TestCase
{
    /** @var PDO */
    protected static $pdo;

    public static function setUpBeforeClass(): void
    {
        try {
            self::$pdo = new PDO(
                'mysql:host=' . $GLOBALS['DB_HOST'],
                $GLOBALS['DB_USER'],
                $GLOBALS['DB_PASS'],
                [
                    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                ]
            );
            self::$pdo->exec(
                'CREATE DATABASE IF NOT EXISTS ' . $GLOBALS['DB_NAME'] .
                ' CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;' .
                'USE ' . $GLOBALS['DB_NAME']
            );
        } catch (PDOException $e) {
            echo "\n\e[31m" . ' PDO EXCEPTION: ' . "\e[0m " . $e->getMessage() . "\n";
        }
    }

    public static function tearDownAfterClass(): void
    {
        if (self::$pdo instanceof PDO) {
            self::$pdo->exec('DROP DATABASE IF EXISTS ' . $GLOBALS['DB_NAME']);
        }
    }

    public function loadSqlDump(string $file)
    {
        if (null !== self::$pdo && file_exists($file)) {
            $errors = $this->parseSql($file, self::$pdo);

            if (! empty($errors)) {
                echo 'SQL File ' . $file . ' following errors occurred:' . "\n";
                echo "\n" . implode("\n", $errors) . "\n";
            }
        } else {
            $this->markTestSkipped('Database dump not found: ' . $file);
        }
    }

    private function parseSql($file, PDO $pdo)
    {
        $errors = [];

        $query = fread(fopen($file, 'r'), filesize($file));
        $query = trim($query);
        $query = preg_replace("/\n\#[^\n]*/", '', "\n" . $query);
        $buffer = [];
        $ret = [];
        $in_string = false;
        for ($i = 0; $i < strlen($query) - 1; $i++) {
            if ($query[$i] == ';' && ! $in_string) {
                $ret[] = substr($query, 0, $i);
                $query = substr($query, $i + 1);
                $i = 0;
            }
            if ($in_string && ($query[$i] == $in_string) && $buffer[1] != '\\') {
                $in_string = false;
            } elseif (! $in_string && ($query[$i] == '"' || $query[$i] == "'") && (! isset($buffer[0]) || $buffer[0] != '\\')) {
                $in_string = $query[$i];
            }
            if (isset($buffer[1])) {
                $buffer[0] = $buffer[1];
            }
            $buffer[1] = $query[$i];
        }
        if (! empty($query)) {
            $ret[] = $query;
        }
        for ($i = 0; $i < count($ret); $i++) {
            $ret[$i] = trim($ret[$i]);
            if (! empty($ret[$i]) && $ret[$i] != '#') {
                try {
                    $pdo->query($ret[$i]);
                } catch (PDOException $e) {
                    $errors[] = $e->getMessage();
                }
            }
        }

        return $errors;
    }
}
