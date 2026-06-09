<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Symfony\UX\ShareLink\Registry;

use Symfony\UX\ShareLink\Exception\UnknownProviderException;
use Symfony\UX\ShareLink\Provider\ShareLinkProviderInterface;
use Symfony\UX\ShareLink\Shareable;
use Symfony\UX\ShareLink\ShareLink;

/**
 * @author Romain Monteil <monteil.romain@gmail.com>
 */
final class ShareLinkProviderRegistry
{
    /** @var array<string, ShareLinkProviderInterface> */
    private array $providers = [];

    /**
     * @param iterable<ShareLinkProviderInterface> $providers
     */
    public function __construct(iterable $providers)
    {
        foreach ($providers as $provider) {
            $this->providers[$provider->getName()] = $provider;
        }
    }

    public function has(string $name): bool
    {
        return isset($this->providers[$name]);
    }

    public function get(string $name): ShareLinkProviderInterface
    {
        if (!isset($this->providers[$name])) {
            throw new UnknownProviderException($name, array_keys($this->providers));
        }

        return $this->providers[$name];
    }

    /**
     * @return array<string, ShareLinkProviderInterface>
     */
    public function all(): array
    {
        return $this->providers;
    }

    public function generate(Shareable $shareable, string $provider): ShareLink
    {
        return $this->get($provider)->generate($shareable);
    }

    /**
     * @return array<string, ShareLink>
     */
    public function generateAll(Shareable $shareable): array
    {
        $links = [];
        foreach ($this->providers as $name => $provider) {
            $links[$name] = $provider->generate($shareable);
        }

        return $links;
    }
}
