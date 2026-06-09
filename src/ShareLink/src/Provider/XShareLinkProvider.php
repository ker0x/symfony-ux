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
 * Generates an X (formerly Twitter) share link using the Tweet Web Intent.
 *
 * @see https://docs.x.com/x-for-websites/web-intents/overview
 *
 * @author Romain Monteil <monteil.romain@gmail.com>
 */
final class XShareLinkProvider implements ShareLinkProviderInterface
{
    private const BASE_URL = 'https://x.com/intent/tweet';

    public function getName(): string
    {
        return 'x';
    }

    public function getLabel(): string
    {
        return 'X';
    }

    public function generate(Shareable $shareable): ShareLink
    {
        $params = ['url' => $shareable->url];

        $text = $shareable->title ?? $shareable->text;
        if (null !== $text && '' !== $text) {
            $params['text'] = $text;
        }

        if ([] !== $shareable->hashtags) {
            $params['hashtags'] = implode(',', $shareable->hashtags);
        }

        if (null !== $shareable->via && '' !== $shareable->via) {
            $params['via'] = ltrim($shareable->via, '@');
        }

        $url = self::BASE_URL.'?'.http_build_query($params, '', '&', \PHP_QUERY_RFC3986);

        return new ShareLink($this->getName(), $this->getLabel(), $url);
    }
}
