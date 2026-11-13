<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Symfony\UX\Turbo\Tests\Fixtures;

use Doctrine\DBAL\DriverManager;
use Doctrine\DBAL\Types\Type;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\ORMSetup;
use Doctrine\ORM\Tools\SchemaTool;
use Symfony\Bridge\Doctrine\Types\UlidType;
use Symfony\Bridge\Doctrine\Types\UuidType;

/**
 * Creates an in-memory sqlite EntityManager holding every entity under Fixtures/Entity.
 *
 * @internal
 */
final class EntityManagerFactory
{
    public static function create(): EntityManager
    {
        foreach ([UuidType::NAME => UuidType::class, UlidType::NAME => UlidType::class] as $name => $class) {
            if (!Type::hasType($name)) {
                Type::addType($name, $class);
            }
        }

        $config = ORMSetup::createAttributeMetadataConfiguration(
            paths: [__DIR__.'/Entity'],
            isDevMode: true,
        );

        // @phpstan-ignore function.alreadyNarrowedType (ORM 2 has no native lazy objects, and needs none)
        if (method_exists($config, 'enableNativeLazyObjects')) {
            $config->enableNativeLazyObjects(true);
        }

        $entityManager = new EntityManager(
            DriverManager::getConnection(['driver' => 'pdo_sqlite', 'memory' => true], $config),
            $config,
        );

        new SchemaTool($entityManager)->createSchema($entityManager->getMetadataFactory()->getAllMetadata());

        return $entityManager;
    }
}
