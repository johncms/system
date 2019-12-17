<?php

/**
 * This file is part of JohnCMS Content Management System.
 *
 * @copyright JohnCMS Community
 * @license   https://opensource.org/licenses/GPL-3.0 GPL-3.0
 * @link      https://johncms.com JohnCMS Project
 */

declare(strict_types=1);

namespace Johncms\System\Http;

use Psr\Container\ContainerInterface;
use Psr\Http\Message\ServerRequestInterface;

class Environment
{
    private $ip;

    private $ipViaProxy;

    private $userAgent;

    private $ipCount = [];

    /** @var ContainerInterface */
    private $container;

    /** @var array */
    private $server;

    public function __invoke(ContainerInterface $container)
    {
        $this->container = $container;
        $request = $container->get(ServerRequestInterface::class);
        $this->server = $request->getServerParams();
        $this->ipLog($this->getIp());

        return $this;
    }

    public function getIp(): int
    {
        if (null === $this->ip) {
            $ip = filter_var($this->server['REMOTE_ADDR'], FILTER_VALIDATE_IP);
            $ip = ip2long($ip);
            $this->ip = sprintf('%u', $ip);
        }

        return (int) $this->ip;
    }

    public function getIpViaProxy(): int
    {
        if ($this->ipViaProxy !== null) {
            return $this->ipViaProxy;
        }

        if (
            isset($this->server['HTTP_X_FORWARDED_FOR'])
            && preg_match_all(
                '#\d{1,3}\.\d{1,3}\.\d{1,3}\.\d{1,3}#s',
                filter_var($this->server['HTTP_X_FORWARDED_FOR'], FILTER_SANITIZE_STRING),
                $vars
            )
        ) {
            foreach ($vars[0] as $var) {
                $ipViaProxy = ip2long($var);

                if ($ipViaProxy && $ipViaProxy != $this->getIp() && ! preg_match('#^(10|172\.16|192\.168)\.#', $var)) {
                    return $this->ipViaProxy = (int) sprintf('%u', $ipViaProxy);
                }
            }
        }

        return $this->ipViaProxy = 0;
    }

    public function getUserAgent(): string
    {
        if ($this->userAgent !== null) {
            return $this->userAgent;
        }

        if (isset($this->server['HTTP_USER_AGENT'])) {
            return $this->userAgent = mb_substr(
                filter_var($this->server['HTTP_USER_AGENT'], FILTER_SANITIZE_SPECIAL_CHARS),
                0,
                150
            );
        }

        return $this->userAgent = 'Not Recognised';
    }

    public function getIpLog(): array
    {
        return $this->ipCount;
    }

    private function ipLog($ip): void
    {
        $file = CACHE_PATH . 'ip-requests-list.cache';
        $tmp = [];

        if (! file_exists($file)) {
            $in = fopen($file, 'w+');
        } else {
            $in = fopen($file, 'r+');
        }

        flock($in, LOCK_EX) || die('Cannot flock ANTIFLOOD file.');
        $now = time();

        while ($block = fread($in, 8)) {
            $arr = unpack('Lip/Ltime', $block);

            if (($now - $arr['time']) > 60) {
                continue;
            }

            $tmp[] = $arr;
            $this->ipCount[] = $arr['ip'];
        }

        fseek($in, 0);
        ftruncate($in, 0);

        foreach ($tmp as $iValue) {
            fwrite($in, pack('LL', $iValue['ip'], $iValue['time']));
        }

        fwrite($in, pack('LL', $ip, $now));
        fclose($in);
    }
}
