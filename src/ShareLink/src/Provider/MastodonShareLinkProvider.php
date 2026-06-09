<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Symfony\UX\ShareLink\Provider;

use Symfony\UX\ShareLink\Exception\InvalidArgumentException;
use Symfony\UX\ShareLink\Shareable;
use Symfony\UX\ShareLink\ShareLink;

/**
 * Generates a Mastodon share link using each instance's web `/share` endpoint.
 *
 * Mastodon is federated; the `/share` route is part of the standard Mastodon web UI
 * served by every instance, but is not formally covered in Mastodon's API documentation.
 *
 * @author Romain Monteil <monteil.romain@gmail.com>
 */
final class MastodonShareLinkProvider implements ShareLinkProviderInterface
{
    private readonly string $instance;

    /**
     * Mastodon is federated: the share dialog must point at the user's home instance.
     * Override the default instance host (e.g. "mastodon.social") via DI when registering
     * the service if you want to target your own community.
     */
    public function __construct(string $instance = 'mastodon.social')
    {
        $instance = trim($instance);
        if ('' === $instance) {
            throw new InvalidArgumentException('Mastodon instance host must not be empty.');
        }
        $this->instance = $instance;
    }

    public function getName(): string
    {
        return 'mastodon';
    }

    public function getLabel(): string
    {
        return 'Mastodon';
    }

    public function generate(Shareable $shareable): ShareLink
    {
        // Mastodon's share endpoint exposes a single `text` parameter; embed the URL within it.
        $message = $shareable->title ?? $shareable->text;
        $text = null !== $message && '' !== $message
            ? $message.' '.$shareable->url
            : $shareable->url;

        $url = 'https://'.$this->instance.'/share?'.http_build_query(['text' => $text], '', '&', \PHP_QUERY_RFC3986);

        return new ShareLink($this->getName(), $this->getLabel(), $url);
    }
}
