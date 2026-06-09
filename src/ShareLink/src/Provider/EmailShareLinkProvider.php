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
 * Generates a `mailto:` share link, as defined by RFC 6068.
 *
 * @see https://datatracker.ietf.org/doc/html/rfc6068
 *
 * @author Romain Monteil <monteil.romain@gmail.com>
 */
final class EmailShareLinkProvider implements ShareLinkProviderInterface
{
    public function getName(): string
    {
        return 'email';
    }

    public function getLabel(): string
    {
        return 'Email';
    }

    public function generate(Shareable $shareable): ShareLink
    {
        $params = [];

        if (null !== $shareable->title && '' !== $shareable->title) {
            $params['subject'] = $shareable->title;
        }

        $body = null !== $shareable->text && '' !== $shareable->text
            ? $shareable->text."\n\n".$shareable->url
            : $shareable->url;
        $params['body'] = $body;

        $url = 'mailto:'.rawurlencode($shareable->to ?? '');
        if ([] !== $params) {
            $url .= '?'.http_build_query($params, '', '&', \PHP_QUERY_RFC3986);
        }

        return new ShareLink($this->getName(), $this->getLabel(), $url);
    }
}
