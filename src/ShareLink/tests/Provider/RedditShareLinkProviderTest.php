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
use Symfony\UX\ShareLink\Provider\RedditShareLinkProvider;
use Symfony\UX\ShareLink\Shareable;

final class RedditShareLinkProviderTest extends TestCase
{
    public function testBuildsSubmitUrl()
    {
        $provider = new RedditShareLinkProvider();
        $shareable = new Shareable(
            url: 'https://symfony.com',
            title: 'Symfony UX',
        );

        $link = $provider->generate($shareable);

        $this->assertSame('reddit', $link->provider);
        $this->assertSame('Reddit', $link->label);
        $this->assertStringStartsWith('https://www.reddit.com/submit?', $link->url);

        parse_str(parse_url($link->url, \PHP_URL_QUERY), $params);
        $this->assertSame('https://symfony.com', $params['url']);
        $this->assertSame('Symfony UX', $params['title']);
    }

    public function testOmitsTitleWhenMissing()
    {
        $provider = new RedditShareLinkProvider();
        $shareable = new Shareable(url: 'https://symfony.com');

        $link = $provider->generate($shareable);

        parse_str(parse_url($link->url, \PHP_URL_QUERY), $params);
        $this->assertArrayNotHasKey('title', $params);
    }
}
