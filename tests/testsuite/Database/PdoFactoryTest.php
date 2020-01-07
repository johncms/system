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

    public function testFactoryReturnsPdoInstance()
    {
        $container = Mockery::mock(ContainerInterface::class);
        $container
            ->allows()
            ->has('database')
            ->andReturn(true);
        $container
            ->allows()
            ->get('database')
            ->andReturn(['dsn' => 'sqlite::memory:']);
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
