<?php

/**
 * This file is part of JohnCMS Content Management System.
 *
 * @copyright JohnCMS Community
 * @license   https://opensource.org/licenses/GPL-3.0 GPL-3.0
 * @link      https://johncms.com JohnCMS Project
 */

declare(strict_types=1);

namespace Johncms\System\i18n;

use Johncms\System\Users\User;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ServerRequestInterface;
use Zend\I18n\Translator\Translator;

class TranslatorServiceFactory
{
    /** @var array */
    private $config;

    /** @var null|string */
    private $setLng;

    public function __invoke(ContainerInterface $container)
    {
        /** @var ServerRequestInterface $request */
        $request = $container->get(ServerRequestInterface::class);
        $this->setLng = $request->getParsedBody()['setlng'] ?? null;

        // Configure the translator
        $config = $container->get('config');
        $this->config = $config['johncms'] ?? [];
        $trConfig = $config['translator'] ?? [];
        $translator = Translator::factory($trConfig);
        $translator->setLocale($this->determineLocale($container));

        return $translator;
    }

    /**
     * @psalm-suppress UndefinedPropertyFetch
     * @psalm-suppress UndefinedInterfaceMethod
     * @psalm-suppress RedundantConditionGivenDocblockType
     * @param ContainerInterface $container
     * @return string
     */
    private function determineLocale(ContainerInterface $container): string
    {
        /** @var User $userConfig */
        $userConfig = $container->get(User::class)->config;

        if (null !== $this->setLng && array_key_exists($this->setLng, $this->config['lng_list'])) {
            $locale = trim($this->setLng);
            $_SESSION['lng'] = $locale;
        } elseif (isset($_SESSION['lng']) && array_key_exists($_SESSION['lng'], $this->config['lng_list'])) {
            $locale = $_SESSION['lng'];
        } elseif (isset($userConfig['lng']) && array_key_exists($userConfig['lng'], $this->config['lng_list'])) {
            $locale = $userConfig['lng'];
            $_SESSION['lng'] = $locale;
        } else {
            $locale = $this->config['lng'];
        }

        return $locale;
    }
}
