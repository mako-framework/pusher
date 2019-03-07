<?php

/**
 * @copyright Frederic G. Østby
 * @license   http://www.makoframework.com/license
 */

namespace mako\pusher\tests\unit;

use mako\http\Response;
use mako\http\response\Headers;
use mako\pusher\Pusher;
use Mockery;
use Mockery\Adapter\Phpunit\MockeryPHPUnitIntegration;
use PHPUnit\Framework\TestCase;

/**
 * @group unit
 */
class PusherTest extends TestCase
{
	use MockeryPHPUnitIntegration;

	/**
	 *
	 */
	public function tearDown(): void
	{
		Mockery::close();
	}

	/**
	 *
	 */
	protected function getResponseWithHeaders(...$headerAddArgs)
	{
		$responseHeaders = Mockery::mock(Headers::class);

		$responseHeaders->shouldReceive('add')->once()->with(...$headerAddArgs);

		$response = Mockery::mock(Response::class);

		$response->shouldReceive('getHeaders')->once()->andReturn($responseHeaders);

		return $response;
	}

	/**
	 *
	 */
	public function testWithNothing(): void
	{
		$response = Mockery::mock(Response::class);

		$response->shouldReceive('getHeaders')->never();

		$pusher = new Pusher($response);

		$pusher->addHeaderToResponse();
	}

	/**
	 *
	 */
	public function testPreload(): void
	{
		$response = $this->getResponseWithHeaders('Link', '<foo.css>; rel=preload');

		$pusher = new Pusher($response);

		$this->assertSame('foo.css', $pusher->push('foo.css', ['preload']));

		$pusher->addHeaderToResponse();
	}

	/**
	 *
	 */
	public function testPreloadMultiple(): void
	{
		$response = $this->getResponseWithHeaders('Link', '<foo.css>; rel=preload, <bar.css>; rel=preload');

		$pusher = new Pusher($response);

		$this->assertSame('foo.css', $pusher->push('foo.css', ['preload']));

		$this->assertSame('bar.css', $pusher->push('bar.css', ['preload']));

		$pusher->addHeaderToResponse();
	}

	/**
	 *
	 */
	public function testPreloadWithNopush(): void
	{
		$response = $this->getResponseWithHeaders('Link', '<foo.css>; rel=preload; nopush');

		$pusher = new Pusher($response);

		$this->assertSame('foo.css', $pusher->push('foo.css', ['preload', 'nopush' => true]));

		$pusher->addHeaderToResponse();
	}

	/**
	 *
	 */
	public function testPreloadAsStyle(): void
	{
		$response = $this->getResponseWithHeaders('Link', '<foo.css>; rel=preload; as=style');

		$pusher = new Pusher($response);

		$this->assertSame('foo.css', $pusher->push('foo.css', ['preload', 'as' => 'style']));

		$pusher->addHeaderToResponse();
	}

	public function testDnsPrefetchConvenience(): void
	{
		$response = $this->getResponseWithHeaders('Link', '<https://example.org>; rel=dns-prefetch');

		$pusher = new Pusher($response);

		$this->assertSame('https://example.org', $pusher->dnsPrefetch('https://example.org'));

		$pusher->addHeaderToResponse();
	}

	/**
	 *
	 */
	public function testPreconnectConvenience(): void
	{
		$response = $this->getResponseWithHeaders('Link', '<https://example.org>; rel=preconnect');

		$pusher = new Pusher($response);

		$this->assertSame('https://example.org', $pusher->preconnect('https://example.org'));

		$pusher->addHeaderToResponse();
	}

	/**
	 *
	 */
	public function testPrefetchConvenience(): void
	{
		$response = $this->getResponseWithHeaders('Link', '<https://example.org>; rel=prefetch');

		$pusher = new Pusher($response);

		$this->assertSame('https://example.org', $pusher->prefetch('https://example.org'));

		$pusher->addHeaderToResponse();
	}

	/**
	 *
	 */
	public function testPreloadConvenience(): void
	{
		$response = $this->getResponseWithHeaders('Link', '<foo.css>; rel=preload');

		$pusher = new Pusher($response);

		$this->assertSame('foo.css', $pusher->preload('foo.css'));

		$pusher->addHeaderToResponse();
	}

	/**
	 *
	 */
	public function testPreloadConvenienceWithOptions(): void
	{
		$response = $this->getResponseWithHeaders('Link', '<foo.css>; rel=preload; as=style');

		$pusher = new Pusher($response);

		$this->assertSame('foo.css', $pusher->preload('foo.css', ['as' => 'style']));

		$pusher->addHeaderToResponse();
	}

	/**
	 *
	 */
	public function testPrerenderConvenienceWithOptions(): void
	{
		$response = $this->getResponseWithHeaders('Link', '<foo.css>; rel=prerender');

		$pusher = new Pusher($response);

		$this->assertSame('foo.css', $pusher->prerender('foo.css'));

		$pusher->addHeaderToResponse();
	}
}
