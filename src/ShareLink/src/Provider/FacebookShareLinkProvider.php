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
 * Generates a Facebook share link using the public `sharer.php` endpoint.
 *
 * @see https://developers.facebook.com/docs/plugins/share-button/
 *
 * @author Romain Monteil <monteil.romain@gmail.com>
 */
final class FacebookShareLinkProvider implements ShareLinkProviderInterface
{
    private const BASE_URL = 'https://www.facebook.com/sharer/sharer.php';

    public function getName(): string
    {
        return 'facebook';
    }

    public function getLabel(): string
    {
        return 'Facebook';
    }

    public function generate(Shareable $shareable): ShareLink
    {
        $params = ['u' => $shareable->url];

        $quote = $shareable->text ?? $shareable->title;
        if (null !== $quote && '' !== $quote) {
            $params['quote'] = $quote;
        }

        $url = self::BASE_URL.'?'.http_build_query($params, '', '&', \PHP_QUERY_RFC3986);

        return new ShareLink($this->getName(), $this->getLabel(), $url);
    }
}
