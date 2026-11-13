<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Symfony\UX\Turbo\Tests\Twig;

use PHPUnit\Framework\Attributes\DataProvider;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\Uid\Ulid;
use Symfony\Component\Uid\Uuid;
use Symfony\UX\Turbo\Tests\Fixtures\BlogPost;
use Twig\Environment;

final class DomIdTest extends KernelTestCase
{
    /**
     * @param array<string, mixed> $context
     */
    #[DataProvider('provideTemplates')]
    public function testTurboDomId(string $template, array $context, string $expectedResult): void
    {
        $twig = self::getContainer()->get('twig');
        self::assertInstanceOf(Environment::class, $twig);

        $this->assertSame($expectedResult, $twig->createTemplate($template)->render($context));
    }

    /**
     * @return iterable<array{0: string, 1: array<string, mixed>, 2: string}>
     */
    public static function provideTemplates(): iterable
    {
        yield 'integer id' => [
            '{{ turbo_dom_id(post) }}',
            ['post' => new BlogPost(42)],
            'blog_post_42',
        ];

        yield 'id starting with a digit' => [
            '{{ turbo_dom_id(post) }}',
            ['post' => new BlogPost('3f0c252d-88d4-449e-b5a9-dd793e393354')],
            'blog_post_3f0c252d-88d4-449e-b5a9-dd793e393354',
        ];

        yield 'Uuid id' => [
            '{{ turbo_dom_id(post) }}',
            ['post' => new BlogPost(Uuid::fromString('3f0c252d-88d4-449e-b5a9-dd793e393354'))],
            'blog_post_3f0c252d-88d4-449e-b5a9-dd793e393354',
        ];

        yield 'Ulid id' => [
            '{{ turbo_dom_id(post) }}',
            ['post' => new BlogPost(Ulid::fromString('01ARZ3NDEKTSV4RRFFQ69G5FAV'))],
            'blog_post_01ARZ3NDEKTSV4RRFFQ69G5FAV',
        ];

        yield 'prefix' => [
            "{{ turbo_dom_id(post, 'edit') }}",
            ['post' => new BlogPost(42)],
            'edit_blog_post_42',
        ];

        yield 'object without id' => [
            '{{ turbo_dom_id(post) }}',
            ['post' => new BlogPost()],
            'new_blog_post',
        ];

        yield 'object without id and prefix' => [
            "{{ turbo_dom_id(post, 'edit') }}",
            ['post' => new BlogPost()],
            'edit_blog_post',
        ];

        yield 'escaped in an HTML attribute' => [
            '<div id="{{ turbo_dom_id(post) }}">',
            ['post' => new BlogPost('"><script>')],
            '<div id="blog_post_&quot;&gt;&lt;script&gt;">',
        ];
    }
}
