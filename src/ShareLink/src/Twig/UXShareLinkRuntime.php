<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Symfony\UX\ShareLink\Twig;

use Symfony\UX\ShareLink\Registry\ShareLinkProviderRegistry;
use Symfony\UX\ShareLink\Shareable;
use Symfony\UX\ShareLink\ShareLink;
use Twig\Extension\RuntimeExtensionInterface;

/**
 * @author Romain Monteil <monteil.romain@gmail.com>
 */
final class UXShareLinkRuntime implements RuntimeExtensionInterface
{
    public function __construct(
        private readonly ShareLinkProviderRegistry $registry,
    ) {
    }

    public function link(Shareable $shareable, string $provider): ShareLink
    {
        return $this->registry->generate($shareable, $provider);
    }

    /**
     * @return array<string, ShareLink>
     */
    public function links(Shareable $shareable): array
    {
        return $this->registry->generateAll($shareable);
    }
}
