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

use Symfony\UX\ShareLink\Exception\InvalidArgumentException;

/**
 * @author Romain Monteil <monteil.romain@gmail.com>
 */
final class Shareable
{
    public readonly string $url;

    /** @var list<string> */
    public readonly array $hashtags;

    /**
     * @param list<string> $hashtags one tag per entry, without the leading "#"
     */
    public function __construct(
        string $url,
        public readonly ?string $title = null,
        public readonly ?string $text = null,
        array $hashtags = [],
        public readonly ?string $via = null,
        public readonly ?string $to = null,
    ) {
        $url = trim($url);
        if ('' === $url) {
            throw new InvalidArgumentException('Shareable URL must not be empty.');
        }
        $this->url = $url;

        $normalized = [];
        foreach ($hashtags as $tag) {
            if (!\is_string($tag)) {
                throw new InvalidArgumentException(\sprintf('Hashtags must be strings, "%s" given.', get_debug_type($tag)));
            }
            $tag = ltrim(trim($tag), '#');
            if ('' === $tag) {
                continue;
            }
            $normalized[] = $tag;
        }
        $this->hashtags = $normalized;
    }
}
