<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Symfony\UX\ShareLink\Provider;

use Symfony\UX\ShareLink\Shareable;
use Symfony\UX\ShareLink\ShareLink;

/**
 * Produces a share {@see ShareLink} for a given target (Facebook, X, LinkedIn, mailto: ...).
 *
 * Implementations are registered as services tagged `ux_share_link.provider` and picked up by the
 * {@see \Symfony\UX\ShareLink\Registry\ShareLinkProviderRegistry}.
 *
 * @author Romain Monteil <monteil.romain@gmail.com>
 */
interface ShareLinkProviderInterface
{
    /**
     * Returns the unique machine name identifying this provider (e.g. "facebook", "x", "email").
     *
     * The name is the key used to select a provider in Twig and in the registry.
     */
    public function getName(): string;

    /**
     * Returns a human-readable label suitable for display in UI (e.g. "Facebook", "X").
     */
    public function getLabel(): string;

    /**
     * Builds a {@see ShareLink} for the given shareable according to this provider's URL scheme.
     */
    public function generate(Shareable $shareable): ShareLink;
}
