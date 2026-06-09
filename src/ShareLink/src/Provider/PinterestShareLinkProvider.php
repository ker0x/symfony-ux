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
 * Generates a Pinterest share link using the `pin/create/button` endpoint.
 *
 * @see https://developers.pinterest.com/docs/web-features/buttons/
 *
 * @author Romain Monteil <monteil.romain@gmail.com>
 */
final class PinterestShareLinkProvider implements ShareLinkProviderInterface
{
    private const BASE_URL = 'https://www.pinterest.com/pin/create/button/';

    public function getName(): string
    {
        return 'pinterest';
    }

    public function getLabel(): string
    {
        return 'Pinterest';
    }

    public function generate(Shareable $shareable): ShareLink
    {
        // Pinterest scrapes the destination URL for a pinnable image when `media` is omitted.
        $params = ['url' => $shareable->url];

        $description = $shareable->text ?? $shareable->title;
        if (null !== $description && '' !== $description) {
            $params['description'] = $description;
        }

        $url = self::BASE_URL.'?'.http_build_query($params, '', '&', \PHP_QUERY_RFC3986);

        return new ShareLink($this->getName(), $this->getLabel(), $url);
    }
}
