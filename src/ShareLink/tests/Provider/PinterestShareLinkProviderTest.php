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
use Symfony\UX\ShareLink\Provider\PinterestShareLinkProvider;
use Symfony\UX\ShareLink\Shareable;

final class PinterestShareLinkProviderTest extends TestCase
{
    public function testBuildsPinButtonUrl()
    {
        $provider = new PinterestShareLinkProvider();
        $shareable = new Shareable(
            url: 'https://symfony.com',
            title: 'Symfony UX',
            text: 'Reactive UI without writing JavaScript',
        );

        $link = $provider->generate($shareable);

        $this->assertSame('pinterest', $link->provider);
        $this->assertSame('Pinterest', $link->label);
        $this->assertStringStartsWith('https://www.pinterest.com/pin/create/button/?', $link->url);

        parse_str(parse_url($link->url, \PHP_URL_QUERY), $params);
        $this->assertSame('https://symfony.com', $params['url']);
        $this->assertSame('Reactive UI without writing JavaScript', $params['description']);
    }

    public function testFallsBackToTitleWhenNoText()
    {
        $provider = new PinterestShareLinkProvider();
        $shareable = new Shareable(url: 'https://symfony.com', title: 'Symfony UX');

        $link = $provider->generate($shareable);

        parse_str(parse_url($link->url, \PHP_URL_QUERY), $params);
        $this->assertSame('Symfony UX', $params['description']);
    }
}
