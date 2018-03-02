<?php

/**
 * @copyright Frederic G. Østby
 * @license   http://www.makoframework.com/license
 */

namespace mako\pusher\tests\unit;

use Mockery;
use Mockery\Adapter\Phpunit\MockeryPHPUnitIntegration;

use mako\http\Response;
use mako\http\response\Headers;
use mako\pusher\Pusher;

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
	public function tearDown()
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
	public function testWithNothing()
	{
		$response = Mockery::mock(Response::class);

		$response->shouldReceive('getHeaders')->never();

		$pusher = new Pusher($response);

		$pusher->addHeaderToResponse();
	}

	/**
	 *
	 */
	public function testPreload()
	{
		$response = $this->getResponseWithHeaders('Link', '<foo.css>; rel=preload');

		$pusher = new Pusher($response);

		$this->assertSame('foo.css', $pusher->push('foo.css', ['preload']));

		$pusher->addHeaderToResponse();
	}

	/**
	 *
	 */
	public function testPreloadMultiple()
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
	public function testPreloadWithNopush()
	{
		$response = $this->getResponseWithHeaders('Link', '<foo.css>; rel=preload; nopush');

		$pusher = new Pusher($response);

		$this->assertSame('foo.css', $pusher->push('foo.css', ['preload', 'nopush' => true]));

		$pusher->addHeaderToResponse();
	}

	/**
	 *
	 */
	public function testPreloadAsStyle()
	{
		$response = $this->getResponseWithHeaders('Link', '<foo.css>; rel=preload; as=style');

		$pusher = new Pusher($response);

		$this->assertSame('foo.css', $pusher->push('foo.css', ['preload', 'as' => 'style']));

		$pusher->addHeaderToResponse();
	}

	public function testDnsPrefetchConvenience()
	{
		$response = $this->getResponseWithHeaders('Link', '<https://example.org>; rel=dns-prefetch');

		$pusher = new Pusher($response);

		$this->assertSame('https://example.org', $pusher->dnsPrefetch('https://example.org'));

		$pusher->addHeaderToResponse();
	}

	/**
	 *
	 */
	public function testPreconnectConvenience()
	{
		$response = $this->getResponseWithHeaders('Link', '<https://example.org>; rel=preconnect');

		$pusher = new Pusher($response);

		$this->assertSame('https://example.org', $pusher->preconnect('https://example.org'));

		$pusher->addHeaderToResponse();
	}

	/**
	 *
	 */
	public function testPrefetchConvenience()
	{
		$response = $this->getResponseWithHeaders('Link', '<https://example.org>; rel=prefetch');

		$pusher = new Pusher($response);

		$this->assertSame('https://example.org', $pusher->prefetch('https://example.org'));

		$pusher->addHeaderToResponse();
	}

	/**
	 *
	 */
	public function testPreloadConvenience()
	{
		$response = $this->getResponseWithHeaders('Link', '<foo.css>; rel=preload');

		$pusher = new Pusher($response);

		$this->assertSame('foo.css', $pusher->preload('foo.css'));

		$pusher->addHeaderToResponse();
	}

	/**
	 *
	 */
	public function testPreloadConvenienceWithOptions()
	{
		$response = $this->getResponseWithHeaders('Link', '<foo.css>; rel=preload; as=style');

		$pusher = new Pusher($response);

		$this->assertSame('foo.css', $pusher->preload('foo.css', ['as' => 'style']));

		$pusher->addHeaderToResponse();
	}

	/**
	 *
	 */
	public function testPrerenderConvenienceWithOptions()
	{
		$response = $this->getResponseWithHeaders('Link', '<foo.css>; rel=prerender');

		$pusher = new Pusher($response);

		$this->assertSame('foo.css', $pusher->prerender('foo.css'));

		$pusher->addHeaderToResponse();
	}
}
