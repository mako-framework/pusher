# Mako Pusher

Pusher enables you to easily implement `preloading`, `prefetching`, `prerendering`, `dns-prefetching` and `preconnecting` in your applications.

## Usage

If you're using the `PusherMiddleware` then you can access the pusher instance using the `Request::getAttribute()` method.

	$pusher = $this->request->getAttribute('mako.pusher');

You can tell the client to preload files your assets.

	$pusher->push('/assets/css/style.css', ['preload']);

	// You can also use the "preload" convenience method

	$pusher->preload('/assets/css/style.css');

> Preloading requires a HTTP2 server with push support (e.g. Apache 2.4.24+).

You can tell the browser to prefetch resources that you think the user will need next.

	$pusher->push('https://example.org/image.jpg', ['prefetch', 'as' => 'image']);

	// You can also use the "prefetch" convenience method

	$pusher->prefetch('https://example.org/image.jpg', ['as' => 'image']);

You can tell the browser to prefetch and render resources that you think the user will visit next.

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

### More details

* [https://w3c.github.io/preload/](https://w3c.github.io/preload/)
* [https://w3c.github.io/resource-hints/](https://w3c.github.io/resource-hints/)
