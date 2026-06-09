<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Symfony\UX\ShareLink;

/**
 * @author Romain Monteil <monteil.romain@gmail.com>
 */
final class ShareLink implements \Stringable
{
    public function __construct(
        public readonly string $provider,
        public readonly string $label,
        public readonly string $url,
    ) {
    }

    public function __toString(): string
    {
        return $this->url;
    }
}
