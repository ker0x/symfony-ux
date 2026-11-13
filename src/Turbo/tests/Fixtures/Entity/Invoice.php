<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Symfony\UX\Turbo\Tests\Fixtures\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Types\UlidType;
use Symfony\Component\Uid\Ulid;

/**
 * @internal
 */
#[ORM\Entity]
class Invoice
{
    public function __construct(
        #[ORM\Id]
        #[ORM\Column(type: UlidType::NAME)]
        public Ulid $id,
    ) {
    }
}
