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
 * Generates a WhatsApp share link using the `wa.me` click-to-chat endpoint.
 *
 * @see https://faq.whatsapp.com/5913398998672934
 *
 * @author Romain Monteil <monteil.romain@gmail.com>
 */
final class WhatsAppShareLinkProvider implements ShareLinkProviderInterface
{
    private const BASE_URL = 'https://wa.me/';

    public function getName(): string
    {
        return 'whatsapp';
    }

    public function getLabel(): string
    {
        return 'WhatsApp';
    }

    public function generate(Shareable $shareable): ShareLink
    {
        // WhatsApp's click-to-chat endpoint takes a single `text` parameter; embed the URL within it.
        $message = $shareable->title ?? $shareable->text;
        $text = null !== $message && '' !== $message
            ? $message.' '.$shareable->url
            : $shareable->url;

        $url = self::BASE_URL.'?'.http_build_query(['text' => $text], '', '&', \PHP_QUERY_RFC3986);

        return new ShareLink($this->getName(), $this->getLabel(), $url);
    }
}
