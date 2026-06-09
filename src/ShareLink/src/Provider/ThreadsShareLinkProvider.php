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

use Symfony\UX\ShareLink\Shareable;
use Symfony\UX\ShareLink\ShareLink;

/**
 * Generates a Threads share link using the Post Web Intent.
 *
 * @see https://developers.facebook.com/docs/threads/threads-web-intents
 *
 * @author Romain Monteil <monteil.romain@gmail.com>
 */
final class ThreadsShareLinkProvider implements ShareLinkProviderInterface
{
    private const BASE_URL = 'https://www.threads.net/intent/post';

    public function getName(): string
    {
        return 'threads';
    }

    public function getLabel(): string
    {
        return 'Threads';
    }

    public function generate(Shareable $shareable): ShareLink
    {
        // Threads' intent endpoint exposes a single `text` parameter; embed the URL within it.
        $message = $shareable->title ?? $shareable->text;
        $text = null !== $message && '' !== $message
            ? $message.' '.$shareable->url
            : $shareable->url;

        $url = self::BASE_URL.'?'.http_build_query(['text' => $text], '', '&', \PHP_QUERY_RFC3986);

        return new ShareLink($this->getName(), $this->getLabel(), $url);
    }
}
