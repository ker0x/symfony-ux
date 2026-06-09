<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use Symfony\UX\ShareLink\Provider\BlueskyShareLinkProvider;
use Symfony\UX\ShareLink\Provider\EmailShareLinkProvider;
use Symfony\UX\ShareLink\Provider\FacebookShareLinkProvider;
use Symfony\UX\ShareLink\Provider\LinkedInShareLinkProvider;
use Symfony\UX\ShareLink\Provider\MastodonShareLinkProvider;
use Symfony\UX\ShareLink\Provider\PinterestShareLinkProvider;
use Symfony\UX\ShareLink\Provider\RedditShareLinkProvider;
use Symfony\UX\ShareLink\Provider\TelegramShareLinkProvider;
use Symfony\UX\ShareLink\Provider\ThreadsShareLinkProvider;
use Symfony\UX\ShareLink\Provider\WhatsAppShareLinkProvider;
use Symfony\UX\ShareLink\Provider\XShareLinkProvider;
use Symfony\UX\ShareLink\Registry\ShareLinkProviderRegistry;
use Symfony\UX\ShareLink\Twig\UXShareLinkExtension;
use Symfony\UX\ShareLink\Twig\UXShareLinkRuntime;

use function Symfony\Component\DependencyInjection\Loader\Configurator\service;
use function Symfony\Component\DependencyInjection\Loader\Configurator\tagged_iterator;

return static function (ContainerConfigurator $container): void {
    $services = $container->services();

    $services->set('ux_share_link.provider.email', EmailShareLinkProvider::class)
        ->tag('ux_share_link.provider');

    $services->set('ux_share_link.provider.facebook', FacebookShareLinkProvider::class)
        ->tag('ux_share_link.provider');

    $services->set('ux_share_link.provider.x', XShareLinkProvider::class)
        ->tag('ux_share_link.provider');

    $services->set('ux_share_link.provider.linkedin', LinkedInShareLinkProvider::class)
        ->tag('ux_share_link.provider');

    $services->set('ux_share_link.provider.threads', ThreadsShareLinkProvider::class)
        ->tag('ux_share_link.provider');

    $services->set('ux_share_link.provider.whatsapp', WhatsAppShareLinkProvider::class)
        ->tag('ux_share_link.provider');

    $services->set('ux_share_link.provider.telegram', TelegramShareLinkProvider::class)
        ->tag('ux_share_link.provider');

    $services->set('ux_share_link.provider.reddit', RedditShareLinkProvider::class)
        ->tag('ux_share_link.provider');

    $services->set('ux_share_link.provider.pinterest', PinterestShareLinkProvider::class)
        ->tag('ux_share_link.provider');

    $services->set('ux_share_link.provider.bluesky', BlueskyShareLinkProvider::class)
        ->tag('ux_share_link.provider');

    $services->set('ux_share_link.provider.mastodon', MastodonShareLinkProvider::class)
        ->tag('ux_share_link.provider');

    $services->set('ux_share_link.registry', ShareLinkProviderRegistry::class)
        ->args([tagged_iterator('ux_share_link.provider')]);

    $services->alias(ShareLinkProviderRegistry::class, 'ux_share_link.registry');

    $services->set('ux_share_link.twig.runtime', UXShareLinkRuntime::class)
        ->args([service('ux_share_link.registry')])
        ->tag('twig.runtime');

    $services->set('ux_share_link.twig.extension', UXShareLinkExtension::class)
        ->tag('twig.extension');
};
