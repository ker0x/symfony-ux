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
use Symfony\UX\ShareLink\Exception\InvalidArgumentException;
use Symfony\UX\ShareLink\Provider\MastodonShareLinkProvider;
use Symfony\UX\ShareLink\Shareable;

final class MastodonShareLinkProviderTest extends TestCase
{
    public function testUsesMastodonSocialByDefault()
    {
        $provider = new MastodonShareLinkProvider();
        $shareable = new Shareable(
            url: 'https://symfony.com',
            title: 'Symfony UX',
        );

        $link = $provider->generate($shareable);

        $this->assertSame('mastodon', $link->provider);
        $this->assertSame('Mastodon', $link->label);
        $this->assertStringStartsWith('https://mastodon.social/share?', $link->url);

        parse_str(parse_url($link->url, \PHP_URL_QUERY), $params);
        $this->assertSame('Symfony UX https://symfony.com', $params['text']);
    }

    public function testHonoursCustomInstance()
    {
        $provider = new MastodonShareLinkProvider('fosstodon.org');
        $shareable = new Shareable(url: 'https://symfony.com');

        $link = $provider->generate($shareable);

        $this->assertStringStartsWith('https://fosstodon.org/share?', $link->url);
    }

    public function testRejectsEmptyInstance()
    {
        $this->expectException(InvalidArgumentException::class);

        new MastodonShareLinkProvider('   ');
    }
}
