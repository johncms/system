<?php

/**
 * This file is part of JohnCMS Content Management System.
 *
 * @copyright JohnCMS Community
 * @license   https://opensource.org/licenses/GPL-3.0 GPL-3.0
 * @link      https://johncms.com JohnCMS Project
 */

declare(strict_types=1);

use Codeception\Test\Unit;
use Johncms\System\Http\Request;
use Psr\Http\Message\ServerRequestInterface;

class RequestTest extends Unit
{
    public function testCanCreateInstance(): Request
    {
        /** @var Request $request */
        $request = Request::fromGlobals();
        $this->assertInstanceOf(Request::class, $request);
        $this->assertInstanceOf(ServerRequestInterface::class, $request);
        return $request;
    }

    ////////////////////////////////////////////////////////////////////////////////

    /**
     * @depends testCanCreateInstance
     * @param Request $request
     */
    public function testGetQueryReturnsValueOfRequestedKey(Request $request): void
    {
        $request = $request->withQueryParams(['foo' => 'bar']);
        $this->assertSame('bar', $request->getQuery('foo'));
    }

    /**
     * @depends testCanCreateInstance
     * @param Request $request
     */
    public function testGetQueryWithNonexistentKeyReturnsNull(Request $request): void
    {
        $this->assertNull($request->getQuery('foo'));
    }

    /**
     * @depends testCanCreateInstance
     * @param Request $request
     */
    public function testGetQueryCanReturnsDefaultValue(Request $request): void
    {
        $this->assertSame('default', $request->getQuery('foo', 'default'));
    }

    /**
     * @depends testCanCreateInstance
     * @param Request $request
     */
    public function testGetQueryWithImpassableFilterReturnsNull(Request $request): void
    {
        $request = $request->withQueryParams(['foo' => 'bar']);
        $this->assertNull($request->getQuery('foo', null, FILTER_VALIDATE_INT));
    }

    ////////////////////////////////////////////////////////////////////////////////

    /**
     * @depends testCanCreateInstance
     * @param Request $request
     */
    public function testGetPostReturnsValueOfRequestedKey(Request $request): void
    {
        $request = $request->withParsedBody(['foo' => 'bar']);
        $this->assertSame('bar', $request->getPost('foo'));
    }

    /**
     * @depends testCanCreateInstance
     * @param Request $request
     */
    public function testGetPostWithNonexistentKeyReturnsNull(Request $request): void
    {
        $this->assertNull($request->getPost('foo'));
    }

    /**
     * @depends testCanCreateInstance
     * @param Request $request
     */
    public function testGetPostCanReturnsDefaultValue(Request $request): void
    {
        $this->assertSame('default', $request->getPost('foo', 'default'));
    }

    /**
     * @depends testCanCreateInstance
     * @param Request $request
     */
    public function testGetPostWithImpassableFilterReturnsNull(Request $request): void
    {
        $request = $request->withParsedBody(['foo' => 'bar']);
        $this->assertNull($request->getPost('foo', null, FILTER_VALIDATE_INT));
    }

    ////////////////////////////////////////////////////////////////////////////////

    /**
     * @depends testCanCreateInstance
     * @param Request $request
     */
    public function testGetCookieReturnsValueOfRequestedKey(Request $request): void
    {
        $request = $request->withCookieParams(['foo' => 'bar']);
        $this->assertSame('bar', $request->getCookie('foo'));
    }

    /**
     * @depends testCanCreateInstance
     * @param Request $request
     */
    public function testGetCookieWithNonexistentKeyReturnsNull(Request $request): void
    {
        $this->assertNull($request->getCookie('foo'));
    }

    /**
     * @depends testCanCreateInstance
     * @param Request $request
     */
    public function testGetCookieCanReturnsDefaultValue(Request $request): void
    {
        $this->assertSame('default', $request->getCookie('foo', 'default'));
    }

    /**
     * @depends testCanCreateInstance
     * @param Request $request
     */
    public function testGetCookieWithImpassableFilterReturnsNull(Request $request): void
    {
        $request = $request->withParsedBody(['foo' => 'bar']);
        $this->assertNull($request->getCookie('foo', null, FILTER_VALIDATE_INT));
    }
}
