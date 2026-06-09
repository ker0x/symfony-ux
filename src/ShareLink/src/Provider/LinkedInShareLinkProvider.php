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
 * Generates a LinkedIn share link using the `share-offsite` endpoint.
 *
 * @see https://learn.microsoft.com/en-us/linkedin/consumer/integrations/self-serve/share-on-linkedin
 *
 * @author Romain Monteil <monteil.romain@gmail.com>
 */
final class LinkedInShareLinkProvider implements ShareLinkProviderInterface
{
    private const BASE_URL = 'https://www.linkedin.com/sharing/share-offsite/';

    public function getName(): string
    {
        return 'linkedin';
    }

    public function getLabel(): string
    {
        return 'LinkedIn';
    }

    public function generate(Shareable $shareable): ShareLink
    {
        // LinkedIn's share-offsite endpoint only honours `url`; it scrapes Open Graph metadata
        // from the destination page for the title/summary/image preview.
        $url = self::BASE_URL.'?'.http_build_query(['url' => $shareable->url], '', '&', \PHP_QUERY_RFC3986);

        return new ShareLink($this->getName(), $this->getLabel(), $url);
    }
}
