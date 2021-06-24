<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Symfony\UX\Flatpickr\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\DependencyInjection\Extension\PrependExtensionInterface;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\UX\Flatpickr\Form\FlatpickrType;

/**
 * @author Romain Monteil <monteil.romain@gmail.com>
 *
 * @internal
 */
final class FlatpickrExtension extends Extension implements PrependExtensionInterface
{
    public function prepend(ContainerBuilder $container): void
    {
        // Register the Flatpickr form theme if TwigBundle is available
        $bundles = $container->getParameter('kernel.bundles');

        if (!isset($bundles['TwigBundle'])) {
            return;
        }

        $container->prependExtensionConfig('twig', ['form_themes' => ['@Flatpickr/form_theme.html.twig']]);
    }

    public function load(array $configs, ContainerBuilder $container): void
    {
        $container
            ->setDefinition('form.flatpickr', new Definition(FlatpickrType::class))
            ->addTag('form.type')
            ->setPublic(false)
        ;
    }
}
