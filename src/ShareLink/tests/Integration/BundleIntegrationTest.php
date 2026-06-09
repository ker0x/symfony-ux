<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Symfony\UX\ShareLink\Tests\Integration;

use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\UX\ShareLink\Provider\ShareLinkProviderInterface;
use Symfony\UX\ShareLink\Registry\ShareLinkProviderRegistry;
use Symfony\UX\ShareLink\Shareable;

final class BundleIntegrationTest extends KernelTestCase
{
    public function testContainerCompilesAndRegistersAllProviders()
    {
        $container = self::getContainer();

        /** @var ShareLinkProviderRegistry $registry */
        $registry = $container->get(ShareLinkProviderRegistry::class);

        $this->assertSame(
            ['email', 'facebook', 'x', 'linkedin', 'threads', 'whatsapp', 'telegram', 'reddit', 'pinterest', 'bluesky', 'mastodon'],
            array_keys($registry->all()),
        );

        foreach ($registry->all() as $provider) {
            $this->assertInstanceOf(ShareLinkProviderInterface::class, $provider);
        }
    }

    public function testTwigRendersShareLink()
    {
        $shareable = new Shareable(
            url: 'https://symfony.com',
            title: 'Symfony UX',
        );

        $rendered = self::getContainer()->get('twig')
            ->createTemplate('{{- ux_share_link(shareable, \'facebook\').url }}')
            ->render(['shareable' => $shareable]);

        $this->assertStringStartsWith('https://www.facebook.com/sharer/sharer.php?', $rendered);
        $this->assertStringContainsString('u=https%3A%2F%2Fsymfony.com', $rendered);
    }

    public function testTwigRendersAllShareLinks()
    {
        $shareable = new Shareable(url: 'https://symfony.com');

        $rendered = self::getContainer()->get('twig')
            ->createTemplate('{{- ux_share_links(shareable)|keys|join(\',\') }}')
            ->render(['shareable' => $shareable]);

        $this->assertSame('email,facebook,x,linkedin,threads,whatsapp,telegram,reddit,pinterest,bluesky,mastodon', $rendered);
    }
}
