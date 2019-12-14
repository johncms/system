<?php

/**
 * This file is part of JohnCMS Content Management System.
 *
 * @copyright JohnCMS Community
 * @license   https://opensource.org/licenses/GPL-3.0 GPL-3.0
 * @link      https://johncms.com JohnCMS Project
 */

declare(strict_types=1);

namespace Johncms\System;

use Johncms\System\Database\PdoFactory;
use PDO;

class ConfigProvider
{
    public function __invoke(): array
    {
        return [
            'dependencies' => $this->getDependencies(),
        ];
    }

    private function getDependencies(): array
    {
        return [
            'aliases' => [],

            'factories' => [
                \Johncms\System\Config\Config::class => \Johncms\System\Config\ConfigFactory::class,
                PDO::class                 => PdoFactory::class,
            ],

            'invokables' => [],
        ];
    }
}