<?php

/**
 * This file is part of JohnCMS Content Management System.
 *
 * @copyright JohnCMS Community
 * @license   https://opensource.org/licenses/GPL-3.0 GPL-3.0
 * @link      https://johncms.com JohnCMS Project
 */

declare(strict_types=1);

namespace Test\Suite\Database;

use Johncms\System\Database\PdoFactory;
use Mockery;
use Mockery\Adapter\Phpunit\MockeryPHPUnitIntegration;
use PDO;
use PDOException;
use PHPUnit\Framework\TestCase;
use Psr\Container\ContainerInterface;

class PdoFactoryTest extends TestCase
{
    use MockeryPHPUnitIntegration;

    public function tearDown(): void
    {
        Mockery::close();
    }

    public static function setUpBeforeClass(): void
    {
        try {
            $port = getenv('DB_PORT');
            $pdo = new PDO(
                'mysql:host=' . $GLOBALS['DB_HOST'] . ($port !== false ? ';port=' . $port : ''),
                $GLOBALS['DB_USER'],
                $GLOBALS['DB_PASS'],
                [
                    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                ]
            );
            $pdo->exec(
                'CREATE DATABASE IF NOT EXISTS ' . $GLOBALS['DB_NAME'] .
                ' CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;'
            );
        } catch (PDOException $e) {
            echo "\n\e[31m" . ' PDO EXCEPTION: ' . "\e[0m " . $e->getMessage() . "\n";
        }
    }

    public function testFactoryReturnsPdoInstance()
    {
        self::setUpBeforeClass();
        $port = getenv('DB_PORT');
        $container = Mockery::mock(ContainerInterface::class);
        $container
            ->allows()
            ->has('database')
            ->andReturn(true);
        $container
            ->allows()
            ->get('database')
            ->andReturn(
                [
                    'db_host' => $GLOBALS['DB_HOST'],
                    'db_port' => $port ?? '',
                    'db_user' => $GLOBALS['DB_USER'],
                    'db_pass' => $GLOBALS['DB_PASS'],
                    'db_name' => $GLOBALS['DB_NAME'],
                ]
            );
        $factory = (new PdoFactory())($container);
        $this->assertInstanceOf(PDO::class, $factory);
    }

    public function testtestPdoException(): void
    {
        $container = Mockery::mock(ContainerInterface::class);
        $container
            ->allows()
            ->has('database')
            ->andReturn(false);
        $this->expectException(PDOException::class);
        (new PdoFactory())($container);
    }
}
