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
 * Generates a Bluesky share link using the Compose Action Intent.
 *
 * @see https://docs.bsky.app/docs/advanced-guides/intent-links
 *
 * @author Romain Monteil <monteil.romain@gmail.com>
 */
final class BlueskyShareLinkProvider implements ShareLinkProviderInterface
{
    private const BASE_URL = 'https://bsky.app/intent/compose';

    public function getName(): string
    {
        return 'bluesky';
    }

    public function getLabel(): string
    {
        return 'Bluesky';
    }

    public function generate(Shareable $shareable): ShareLink
    {
        // Bluesky's intent endpoint exposes a single `text` parameter; embed the URL within it.
        $message = $shareable->title ?? $shareable->text;
        $text = null !== $message && '' !== $message
            ? $message.' '.$shareable->url
            : $shareable->url;

        $url = self::BASE_URL.'?'.http_build_query(['text' => $text], '', '&', \PHP_QUERY_RFC3986);

        return new ShareLink($this->getName(), $this->getLabel(), $url);
    }
}
