<?php

/**
 * @copyright Frederic G. Østby
 * @license   http://www.makoframework.com/license
 */

namespace mako\pusher;

use mako\http\Response;

/**
 * Pusher.
 *
 *  @author Frederic G. Østby
 */
class Pusher
{
	/**
	 * Items.
	 *
	 * @var array
	 */
	protected $items;

	/**
	 * Response.
	 *
	 * @var \mako\http\Response
	 */
	protected $response;

	/**
	 * Constructor.
	 *
	 * @param \mako\http\Response $response Response
	 */
	public function __construct(Response $response)
	{
		$this->response = $response;
	}

	/**
	 * Builds the header value.
	 *
	 * @return string
	 */
	protected function buildHeaderValue(): string
	{
		$header = '';

		foreach($this->items as $item => $options)
		{
			$part = sprintf('<%s>; ', $item);

			foreach($options as $key => $value)
			{
				if($value === true)
				{
					$part .= sprintf('%s; ', $key);
				}
				else
				{
					$part .= sprintf('%s=%s; ', (is_int($key) ? 'rel' : $key), $value);
				}
			}

			$header .= sprintf('%s, ', rtrim($part, '; '));
		}

		return rtrim($header, ', ');
	}

	/**
	 * Adds header to the response.
	 */
	public function addHeaderToResponse()
	{
		if(!empty($this->items))
		{
			$this->response->header('Link', $this->buildHeaderValue());
		}
	}

	/**
	 * Adds an item to list.
	 *
	 * @param  string $item    Item url or path
	 * @param  array  $options Options
	 * @return string
	 */
	public function push(string $item, array $options): string
	{
		$this->items[$item] = $options;

		return $item;
	}

	/**
	 * Adds a dns-prefetch item to list.
	 *
	 * @param  string $item    Item url or path
	 * @param  array  $options Options
	 * @return string
	 */
	public function dnsPrefetch(string $item, array $options = []): string
	{
		return $this->push($item, array_merge(['dns-prefetch'], $options));
	}

	/**
	 * Adds a preconnect item to list.
	 *
	 * @param  string $item    Item url or path
	 * @param  array  $options Options
	 * @return string
	 */
	public function preconnect(string $item, array $options = []): string
	{
		return $this->push($item, array_merge(['preconnect'], $options));
	}

	/**
	 * Adds a prefetch item to list.
	 *
	 * @param  string $item    Item url or path
	 * @param  array  $options Options
	 * @return string
	 */
	public function prefetch(string $item, array $options = []): string
	{
		return $this->push($item, array_merge(['prefetch'], $options));
	}

	/**
	 * Adds a preload item to list.
	 *
	 * @param  string $item    Item url or path
	 * @param  array  $options Options
	 * @return string
	 */
	public function preload(string $item, array $options = []): string
	{
		return $this->push($item, array_merge(['preload'], $options));
	}

	/**
	 * Adds a prerender item to list.
	 *
	 * @param  string $item    Item url or path
	 * @param  array  $options Options
	 * @return string
	 */
	public function prerender(string $item, array $options = []): string
	{
		return $this->push($item, array_merge(['prerender'], $options));
	}
}
