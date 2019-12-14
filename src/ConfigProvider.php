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

use Johncms\System\Config;
use Johncms\System\Database\PdoFactory;
use Johncms\System\i18n\TranslatorServiceFactory;
use Johncms\System\Users\User;
use Johncms\System\Users\UserFactory;
use PDO;
use Zend\I18n\Translator\Translator;

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
                Config\Config::class => Config\ConfigFactory::class,
                PDO::class           => PdoFactory::class,
                Translator::class    => TranslatorServiceFactory::class,
                User::class          => UserFactory::class,
            ],

            'invokables' => [],
        ];
    }
}
