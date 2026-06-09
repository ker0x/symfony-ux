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
use Symfony\UX\ShareLink\Provider\LinkedInShareLinkProvider;
use Symfony\UX\ShareLink\Shareable;

final class LinkedInShareLinkProviderTest extends TestCase
{
    public function testBuildsShareOffsiteUrl()
    {
        $provider = new LinkedInShareLinkProvider();
        $shareable = new Shareable(
            url: 'https://symfony.com',
            title: 'Ignored by LinkedIn share-offsite endpoint',
        );

        $link = $provider->generate($shareable);

        $this->assertSame('linkedin', $link->provider);
        $this->assertSame('LinkedIn', $link->label);
        $this->assertSame(
            'https://www.linkedin.com/sharing/share-offsite/?url=https%3A%2F%2Fsymfony.com',
            $link->url,
        );
    }
}
