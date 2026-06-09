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
use Symfony\UX\ShareLink\Provider\EmailShareLinkProvider;
use Symfony\UX\ShareLink\Shareable;

final class EmailShareLinkProviderTest extends TestCase
{
    public function testBuildsMailtoWithAllFields()
    {
        $provider = new EmailShareLinkProvider();
        $shareable = new Shareable(
            url: 'https://symfony.com',
            title: 'Symfony UX',
            text: 'Check this out',
            to: 'hello@example.com',
        );

        $link = $provider->generate($shareable);

        $this->assertSame('email', $link->provider);
        $this->assertStringStartsWith('mailto:hello%40example.com?', $link->url);

        parse_str(parse_url($link->url, \PHP_URL_QUERY), $params);
        $this->assertSame('Symfony UX', $params['subject']);
        $this->assertSame("Check this out\n\nhttps://symfony.com", $params['body']);
    }

    public function testFallsBackToUrlOnlyBody()
    {
        $provider = new EmailShareLinkProvider();
        $shareable = new Shareable(url: 'https://symfony.com');

        $link = $provider->generate($shareable);

        $this->assertSame('mailto:?body=https%3A%2F%2Fsymfony.com', $link->url);
    }
}
