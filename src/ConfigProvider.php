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

use Johncms\System\{
    Config,
    Database\PdoFactory,
    i18n\TranslatorServiceFactory,
    Users\User,
    Users\UserFactory,
    View\Render,
    View\RenderEngineFactory
};
use Johncms\System\View\Extension\Assets;
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
                Assets::class        => Assets::class,
                Config\Config::class => Config\ConfigFactory::class,
                PDO::class           => PdoFactory::class,
                Render::class        => RenderEngineFactory::class,
                Translator::class    => TranslatorServiceFactory::class,
                User::class          => UserFactory::class,
            ],

            'invokables' => [],
        ];
    }
}
