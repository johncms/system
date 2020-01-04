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
use PDO;
use PDOException;
use PHPUnit\Framework\TestCase;
use Laminas\ServiceManager\ServiceManager;

class PdoFactoryTest extends TestCase
{
    public function testFactoryReturnsPdoInstance()
    {
        /** @var ServiceManager $container */
        $container = new ServiceManager();
        $container->setService('database', ['dsn' => 'sqlite::memory:']);
        $factory = (new PdoFactory())($container);
        $this->assertInstanceOf(PDO::class, $factory);
    }

    public function testtestPdoException(): void
    {
        $this->expectException(PDOException::class);
        (new PdoFactory())(new ServiceManager());
    }
}
