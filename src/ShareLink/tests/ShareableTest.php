<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Symfony\UX\ShareLink\Tests;

use PHPUnit\Framework\TestCase;
use Symfony\UX\ShareLink\Exception\InvalidArgumentException;
use Symfony\UX\ShareLink\Shareable;

final class ShareableTest extends TestCase
{
    public function testRejectsEmptyUrl()
    {
        $this->expectException(InvalidArgumentException::class);

        new Shareable(url: '   ');
    }

    public function testTrimsUrl()
    {
        $shareable = new Shareable(url: '  https://symfony.com  ');

        $this->assertSame('https://symfony.com', $shareable->url);
    }

    public function testStripsLeadingHashFromHashtags()
    {
        $shareable = new Shareable(
            url: 'https://symfony.com',
            hashtags: ['#symfony', 'php', '  #ux  '],
        );

        $this->assertSame(['symfony', 'php', 'ux'], $shareable->hashtags);
    }

    public function testDropsEmptyHashtags()
    {
        $shareable = new Shareable(
            url: 'https://symfony.com',
            hashtags: ['', '#', '   ', 'symfony'],
        );

        $this->assertSame(['symfony'], $shareable->hashtags);
    }
}
