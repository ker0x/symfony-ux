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

use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

/**
 * @author Romain Monteil <monteil.romain@gmail.com>
 */
final class UXShareLinkExtension extends AbstractExtension
{
    public function getFunctions(): array
    {
        return [
            new TwigFunction('ux_share_link', [UXShareLinkRuntime::class, 'link']),
            new TwigFunction('ux_share_links', [UXShareLinkRuntime::class, 'links']),
        ];
    }
}
