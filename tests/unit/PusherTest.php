<?php

/**
 * @copyright Frederic G. Østby
 * @license   http://www.makoframework.com/license
 */

namespace mako\pusher\tests\unit;

use Mockery;
use Mockery\Adapter\Phpunit\MockeryPHPUnitIntegration;

use mako\http\Response;
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
	public function testWithNothing()
	{
		$response = Mockery::mock(Response::class);

		$response->shouldReceive('header')->never();

		$pusher = new Pusher($response);

		$pusher->addHeaderToResponse();
	}

	/**
	 *
	 */
	public function testPreload()
	{
		$response = Mockery::mock(Response::class);

		$response->shouldReceive('header')->once()->with('Link', '<foo.css>; rel=preload');

		$pusher = new Pusher($response);

		$pusher->push('foo.css', ['preload']);

		$pusher->addHeaderToResponse();
	}

	/**
	 *
	 */
	public function testPreloadMultiple()
	{
		$response = Mockery::mock(Response::class);

		$response->shouldReceive('header')->once()->with('Link', '<foo.css>; rel=preload, <bar.css>; rel=preload');

		$pusher = new Pusher($response);

		$pusher->push('foo.css', ['preload']);

		$pusher->push('bar.css', ['preload']);

		$pusher->addHeaderToResponse();
	}

	/**
	 *
	 */
	public function testPreloadWithNopush()
	{
		$response = Mockery::mock(Response::class);

		$response->shouldReceive('header')->once()->with('Link', '<foo.css>; rel=preload; nopush');

		$pusher = new Pusher($response);

		$pusher->push('foo.css', ['preload', 'nopush' => true]);

		$pusher->addHeaderToResponse();
	}

	/**
	 *
	 */
	public function testPreloadAsStyle()
	{
		$response = Mockery::mock(Response::class);

		$response->shouldReceive('header')->once()->with('Link', '<foo.css>; rel=preload; as=style');

		$pusher = new Pusher($response);

		$pusher->push('foo.css', ['preload', 'as' => 'style']);

		$pusher->addHeaderToResponse();
	}

	/**
	 *
	 */
	public function testPreconnectConvenience()
	{
		$response = Mockery::mock(Response::class);

		$response->shouldReceive('header')->once()->with('Link', '<https://example.org>; rel=preconnect');

		$pusher = new Pusher($response);

		$pusher->preconnect('https://example.org');

		$pusher->addHeaderToResponse();
	}

	/**
	 *
	 */
	public function testPrefetchConvenience()
	{
		$response = Mockery::mock(Response::class);

		$response->shouldReceive('header')->once()->with('Link', '<https://example.org>; rel=prefetch');

		$pusher = new Pusher($response);

		$pusher->prefetch('https://example.org');

		$pusher->addHeaderToResponse();
	}

	/**
	 *
	 */
	public function testPreloadConvenience()
	{
		$response = Mockery::mock(Response::class);

		$response->shouldReceive('header')->once()->with('Link', '<foo.css>; rel=preload');

		$pusher = new Pusher($response);

		$pusher->preload('foo.css');

		$pusher->addHeaderToResponse();
	}

	/**
	 *
	 */
	public function testPreloadConvenienceWithOptions()
	{
		$response = Mockery::mock(Response::class);

		$response->shouldReceive('header')->once()->with('Link', '<foo.css>; rel=preload; as=style');

		$pusher = new Pusher($response);

		$pusher->preload('foo.css', ['as' => 'style']);

		$pusher->addHeaderToResponse();
	}
}
