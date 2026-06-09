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
use Symfony\UX\ShareLink\Provider\FacebookShareLinkProvider;
use Symfony\UX\ShareLink\Shareable;

final class FacebookShareLinkProviderTest extends TestCase
{
    public function testBuildsSharerUrl()
    {
        $provider = new FacebookShareLinkProvider();
        $shareable = new Shareable(
            url: 'https://symfony.com',
            title: 'Symfony UX',
            text: 'Reactive UI without writing JavaScript',
        );

        $link = $provider->generate($shareable);

        $this->assertSame('facebook', $link->provider);
        $this->assertSame('Facebook', $link->label);
        $this->assertStringStartsWith('https://www.facebook.com/sharer/sharer.php?', $link->url);

        parse_str(parse_url($link->url, \PHP_URL_QUERY), $params);
        $this->assertSame('https://symfony.com', $params['u']);
        $this->assertSame('Reactive UI without writing JavaScript', $params['quote']);
    }

    public function testOmitsQuoteWhenNoTextOrTitle()
    {
        $provider = new FacebookShareLinkProvider();
        $shareable = new Shareable(url: 'https://symfony.com');

        $link = $provider->generate($shareable);

        parse_str(parse_url($link->url, \PHP_URL_QUERY), $params);
        $this->assertArrayNotHasKey('quote', $params);
    }
}
