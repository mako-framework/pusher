# Mako Pusher

Pusher lets you use `HTTP2 server push` and `prefetching` in your applications.

## Usage

If you're using the `PusherMiddleware` then you can access the pusher instance using the `Request::getAttribute()` method.

	$pusher = $this->request->getAttribute('mako.pusher');

You can tell the client to preload files your assets.

	$pusher->push('/assets/css/style.css', ['preload']);

	// You can also use the "preload" convenience method

	$pusher->preload('/assets/css/style.css');

> Preloading requires a HTTP2 server with push support.

You can prefetch resources that you think the user will need next.

	$pusher->push('https://example.org/image.jpg', ['prefetch', 'as' => 'image']);

	// You can also use the "prefetch" convenience method

	$pusher->prefetch('https://example.org/image.jpg', ['as' => 'image']);

You can prefetch and render resources that you think the user will visit next.

	$pusher->push('https://example.org/next', ['prerender']);

	// You can also use the "prerender" convenience method

	$pusher->prerender('https://example.org/next');

You can resolve the DNS lookup for a domain that you know your client will have to connect to when fetching resources.

	$pusher->push('https://fonts.gstatic.com', ['dns-prefetch']);

	// You can also use the "dnsPrefetch" convenience method

	$pusher->dnsPrefetch('https://fonts.gstatic.com');

You can pre-connect to a domain that you know your client will have to connect to when fetching resources. This will resolve the DNS lookup but it also includes the TCP handshake, and optional TLS negotiation.

	$pusher->push('https://fonts.gstatic.com', ['preconnect', 'crossorigin' => true]);

	// You can also use the "preconnect" convenience method

	$pusher->preconnect('https://fonts.gstatic.com', ['crossorigin' => true]);
