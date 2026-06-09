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
 * Generates a Telegram share link using the official sharing-button widget.
 *
 * @see https://core.telegram.org/widgets/share
 *
 * @author Romain Monteil <monteil.romain@gmail.com>
 */
final class TelegramShareLinkProvider implements ShareLinkProviderInterface
{
    private const BASE_URL = 'https://t.me/share/url';

    public function getName(): string
    {
        return 'telegram';
    }

    public function getLabel(): string
    {
        return 'Telegram';
    }

    public function generate(Shareable $shareable): ShareLink
    {
        $params = ['url' => $shareable->url];

        $message = $shareable->title ?? $shareable->text;
        if (null !== $message && '' !== $message) {
            $params['text'] = $message;
        }

        $url = self::BASE_URL.'?'.http_build_query($params, '', '&', \PHP_QUERY_RFC3986);

        return new ShareLink($this->getName(), $this->getLabel(), $url);
    }
}
