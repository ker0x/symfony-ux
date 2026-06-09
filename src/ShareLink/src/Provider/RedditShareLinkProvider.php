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
 * Generates a Reddit share link using the public `/submit` endpoint.
 *
 * The endpoint is widely used but is not formally covered in Reddit's API documentation.
 *
 * @author Romain Monteil <monteil.romain@gmail.com>
 */
final class RedditShareLinkProvider implements ShareLinkProviderInterface
{
    private const BASE_URL = 'https://www.reddit.com/submit';

    public function getName(): string
    {
        return 'reddit';
    }

    public function getLabel(): string
    {
        return 'Reddit';
    }

    public function generate(Shareable $shareable): ShareLink
    {
        $params = ['url' => $shareable->url];

        if (null !== $shareable->title && '' !== $shareable->title) {
            $params['title'] = $shareable->title;
        }

        $url = self::BASE_URL.'?'.http_build_query($params, '', '&', \PHP_QUERY_RFC3986);

        return new ShareLink($this->getName(), $this->getLabel(), $url);
    }
}
