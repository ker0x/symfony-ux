<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Symfony\UX\ShareLink\Tests\Provider;

use PHPUnit\Framework\TestCase;
use Symfony\UX\ShareLink\Provider\WhatsAppShareLinkProvider;
use Symfony\UX\ShareLink\Shareable;

final class WhatsAppShareLinkProviderTest extends TestCase
{
    public function testEmbedsTextAndUrl()
    {
        $provider = new WhatsAppShareLinkProvider();
        $shareable = new Shareable(
            url: 'https://symfony.com',
            title: 'Symfony UX',
        );

        $link = $provider->generate($shareable);

        $this->assertSame('whatsapp', $link->provider);
        $this->assertSame('WhatsApp', $link->label);
        $this->assertStringStartsWith('https://wa.me/?', $link->url);

        parse_str(parse_url($link->url, \PHP_URL_QUERY), $params);
        $this->assertSame('Symfony UX https://symfony.com', $params['text']);
    }

    public function testFallsBackToUrlOnly()
    {
        $provider = new WhatsAppShareLinkProvider();
        $shareable = new Shareable(url: 'https://symfony.com');

        $link = $provider->generate($shareable);

        parse_str(parse_url($link->url, \PHP_URL_QUERY), $params);
        $this->assertSame('https://symfony.com', $params['text']);
    }
}
