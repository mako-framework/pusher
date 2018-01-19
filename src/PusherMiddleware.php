<?php

/**
 * @copyright Frederic G. Østby
 * @license   http://www.makoframework.com/license
 */

namespace mako\pusher;

use Closure;

use mako\http\Request;
use mako\http\Response;
use mako\http\routing\middleware\Middleware;
use mako\pusher\Pusher;

/**
 * Pusher middleware.
 *
 * @author Frederic G. Østby
 */
class PusherMiddleware extends Middleware
{
	/**
	 * {@inheritdoc}
	 */
	public function execute(Request $request, Response $response, Closure $next): Response
	{
		$pusher = new Pusher($response);

		$request->setAttribute('mako.pusher', $pusher);

		$response = $next($request, $response);

		$pusher->addHeaderToResponse();

		return $response;
	}
}
