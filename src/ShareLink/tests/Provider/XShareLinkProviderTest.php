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
use Symfony\UX\ShareLink\Provider\XShareLinkProvider;
use Symfony\UX\ShareLink\Shareable;

final class XShareLinkProviderTest extends TestCase
{
    public function testBuildsIntentUrl()
    {
        $provider = new XShareLinkProvider();
        $shareable = new Shareable(
            url: 'https://symfony.com',
            title: 'Symfony UX',
            hashtags: ['symfony', 'php', 'ux'],
            via: 'symfony',
        );

        $link = $provider->generate($shareable);

        $this->assertSame('x', $link->provider);
        $this->assertSame('X', $link->label);
        $this->assertStringStartsWith('https://x.com/intent/tweet?', $link->url);

        parse_str(parse_url($link->url, \PHP_URL_QUERY), $params);
        $this->assertSame('https://symfony.com', $params['url']);
        $this->assertSame('Symfony UX', $params['text']);
        $this->assertSame('symfony,php,ux', $params['hashtags']);
        $this->assertSame('symfony', $params['via']);
    }

    public function testStripsLeadingAtFromVia()
    {
        $provider = new XShareLinkProvider();
        $shareable = new Shareable(
            url: 'https://symfony.com',
            via: '@symfony',
        );

        $link = $provider->generate($shareable);

        parse_str(parse_url($link->url, \PHP_URL_QUERY), $params);
        $this->assertSame('symfony', $params['via']);
    }
}
