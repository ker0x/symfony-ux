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
use Symfony\UX\ShareLink\Provider\TelegramShareLinkProvider;
use Symfony\UX\ShareLink\Shareable;

final class TelegramShareLinkProviderTest extends TestCase
{
    public function testBuildsShareUrl()
    {
        $provider = new TelegramShareLinkProvider();
        $shareable = new Shareable(
            url: 'https://symfony.com',
            title: 'Symfony UX',
        );

        $link = $provider->generate($shareable);

        $this->assertSame('telegram', $link->provider);
        $this->assertSame('Telegram', $link->label);
        $this->assertStringStartsWith('https://t.me/share/url?', $link->url);

        parse_str(parse_url($link->url, \PHP_URL_QUERY), $params);
        $this->assertSame('https://symfony.com', $params['url']);
        $this->assertSame('Symfony UX', $params['text']);
    }

    public function testOmitsTextWhenMissing()
    {
        $provider = new TelegramShareLinkProvider();
        $shareable = new Shareable(url: 'https://symfony.com');

        $link = $provider->generate($shareable);

        parse_str(parse_url($link->url, \PHP_URL_QUERY), $params);
        $this->assertArrayNotHasKey('text', $params);
    }
}
