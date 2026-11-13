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

use Doctrine\Persistence\ManagerRegistry;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Uid\Ulid;
use Symfony\Component\Uid\Uuid;
use Symfony\Contracts\Service\ServiceLocatorTrait;
use Symfony\Contracts\Service\ServiceProviderInterface;
use Symfony\UX\Turbo\Broadcaster\IdAccessor;
use Symfony\UX\Turbo\StreamSourceRendererInterface;
use Symfony\UX\Turbo\Tests\Fixtures\Entity\Invoice;
use Symfony\UX\Turbo\Tests\Fixtures\Entity\Membership;
use Symfony\UX\Turbo\Tests\Fixtures\Entity\Player;
use Symfony\UX\Turbo\Tests\Fixtures\Entity\Team;
use Symfony\UX\Turbo\Tests\Fixtures\Entity\Ticket;
use Symfony\UX\Turbo\Tests\Fixtures\EntityManagerFactory;
use Symfony\UX\Turbo\TurboFrame;
use Symfony\UX\Turbo\Twig\TurboRuntime;
use Symfony\UX\Turbo\Twig\TurboStreamListenRendererInterface;
use Twig\Environment;

final class TurboRuntimeTest extends TestCase
{
    public function testRenderTurboStreamFrom(): void
    {
        $twig = $this->createStub(Environment::class);
        $renderer = $this->createMock(StreamSourceRendererInterface::class);
        $renderer->expects($this->once())
            ->method('render')
            ->with('a_topic', ['private' => false])
            ->willReturn('<turbo-mercure-stream-source src="https://hub/.well-known/mercure?topic=a_topic"></turbo-mercure-stream-source>')
        ;
        $streamSourceRenderers = new class(['default' => static fn () => $renderer]) implements ServiceProviderInterface {
            use ServiceLocatorTrait;
        };
        $renderers = new class([]) implements ServiceProviderInterface {
            use ServiceLocatorTrait;
        };

        $runtime = new TurboRuntime($renderers, 'default', new TurboFrame(new RequestStack()), $streamSourceRenderers, new IdAccessor());
        $html = $runtime->renderTurboStreamFrom($twig, 'a_topic');

        $this->assertSame(
            '<turbo-mercure-stream-source src="https://hub/.well-known/mercure?topic=a_topic"></turbo-mercure-stream-source>',
            $html,
        );
    }

    public function testRenderTurboStreamFromPrivate(): void
    {
        $twig = $this->createStub(Environment::class);
        $renderer = $this->createMock(StreamSourceRendererInterface::class);
        $renderer->expects($this->once())
            ->method('render')
            ->with('a_topic', ['private' => true])
            ->willReturn('<turbo-mercure-stream-source src="https://hub/.well-known/mercure?topic=a_topic" private></turbo-mercure-stream-source>')
        ;
        $streamSourceRenderers = new class(['default' => static fn () => $renderer]) implements ServiceProviderInterface {
            use ServiceLocatorTrait;
        };
        $renderers = new class([]) implements ServiceProviderInterface {
            use ServiceLocatorTrait;
        };

        $runtime = new TurboRuntime($renderers, 'default', new TurboFrame(new RequestStack()), $streamSourceRenderers, new IdAccessor());
        $html = $runtime->renderTurboStreamFrom($twig, 'a_topic', true);

        $this->assertSame(
            '<turbo-mercure-stream-source src="https://hub/.well-known/mercure?topic=a_topic" private></turbo-mercure-stream-source>',
            $html,
        );
    }

    public function testRenderTurboStreamFromWithAttributes(): void
    {
        $twig = $this->createStub(Environment::class);
        $renderer = $this->createMock(StreamSourceRendererInterface::class);
        $renderer->expects($this->once())
            ->method('render')
            ->with('a_topic', ['private' => false, 'attributes' => ['id' => 'a_topic_stream']])
            ->willReturn('<turbo-mercure-stream-source src="https://hub/.well-known/mercure?topic=a_topic" id="a_topic_stream"></turbo-mercure-stream-source>')
        ;
        $streamSourceRenderers = new class(['default' => static fn () => $renderer]) implements ServiceProviderInterface {
            use ServiceLocatorTrait;
        };
        $renderers = new class([]) implements ServiceProviderInterface {
            use ServiceLocatorTrait;
        };

        $runtime = new TurboRuntime($renderers, 'default', new TurboFrame(new RequestStack()), $streamSourceRenderers, new IdAccessor());
        $html = $runtime->renderTurboStreamFrom($twig, 'a_topic', false, null, ['id' => 'a_topic_stream']);

        $this->assertSame(
            '<turbo-mercure-stream-source src="https://hub/.well-known/mercure?topic=a_topic" id="a_topic_stream"></turbo-mercure-stream-source>',
            $html,
        );
    }

    public function testRenderTurboStreamFromWithSubscribe(): void
    {
        $twig = $this->createStub(Environment::class);
        $renderer = $this->createMock(StreamSourceRendererInterface::class);
        $renderer->expects($this->once())
            ->method('render')
            ->with('chat', ['private' => true, 'subscribe' => ['chat', 'news']])
            ->willReturn('<turbo-mercure-stream-source src="https://hub/.well-known/mercure?topic=chat" private></turbo-mercure-stream-source>')
        ;
        $streamSourceRenderers = new class(['default' => static fn () => $renderer]) implements ServiceProviderInterface {
            use ServiceLocatorTrait;
        };
        $renderers = new class([]) implements ServiceProviderInterface {
            use ServiceLocatorTrait;
        };

        $runtime = new TurboRuntime($renderers, 'default', new TurboFrame(new RequestStack()), $streamSourceRenderers, new IdAccessor());
        $html = $runtime->renderTurboStreamFrom($twig, 'chat', true, null, [], ['chat', 'news']);

        $this->assertSame(
            '<turbo-mercure-stream-source src="https://hub/.well-known/mercure?topic=chat" private></turbo-mercure-stream-source>',
            $html,
        );
    }

    public function testRenderTurboStreamFromRejectsSubscribeWithoutPrivate(): void
    {
        $twig = $this->createStub(Environment::class);
        $renderer = $this->createMock(StreamSourceRendererInterface::class);
        $renderer->expects($this->never())->method('render');
        $streamSourceRenderers = new class(['default' => static fn () => $renderer]) implements ServiceProviderInterface {
            use ServiceLocatorTrait;
        };
        $renderers = new class([]) implements ServiceProviderInterface {
            use ServiceLocatorTrait;
        };

        $runtime = new TurboRuntime($renderers, 'default', new TurboFrame(new RequestStack()), $streamSourceRenderers, new IdAccessor());

        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('The "subscribe" option of turbo_stream_from() needs the "private" option.');

        $runtime->renderTurboStreamFrom($twig, 'chat', false, null, [], ['chat', 'news']);
    }

    public function testRenderTurboStreamFromUsesCustomRenderer(): void
    {
        $twig = $this->createStub(Environment::class);
        $renderer = $this->createStub(StreamSourceRendererInterface::class);
        $renderer->method('render')->willReturn('<my-custom-stream-source src="https://my-transport.example.com/subscribe?topic=chat"></my-custom-stream-source>');
        $streamSourceRenderers = new class(['default' => static fn () => $renderer]) implements ServiceProviderInterface {
            use ServiceLocatorTrait;
        };
        $renderers = new class([]) implements ServiceProviderInterface {
            use ServiceLocatorTrait;
        };

        $runtime = new TurboRuntime($renderers, 'default', new TurboFrame(new RequestStack()), $streamSourceRenderers, new IdAccessor());
        $html = $runtime->renderTurboStreamFrom($twig, 'chat');

        $this->assertSame(
            '<my-custom-stream-source src="https://my-transport.example.com/subscribe?topic=chat"></my-custom-stream-source>',
            $html,
        );
    }

    public function testRenderTurboStreamFromUnknownTransport(): void
    {
        $this->expectException(\InvalidArgumentException::class);

        $twig = $this->createStub(Environment::class);
        $streamSourceRenderers = new class([]) implements ServiceProviderInterface {
            use ServiceLocatorTrait;
        };
        $renderers = new class([]) implements ServiceProviderInterface {
            use ServiceLocatorTrait;
        };

        $runtime = new TurboRuntime($renderers, 'default', new TurboFrame(new RequestStack()), $streamSourceRenderers, new IdAccessor());
        $runtime->renderTurboStreamFrom($twig, 'a_topic');
    }

    public function testRenderTurboStreamListen(): void
    {
        $twig = $this->createStub(Environment::class);
        $renderer = $this->createMock(TurboStreamListenRendererInterface::class);
        $renderer->expects($this->once())
            ->method('renderTurboStreamListen')
            ->willReturn('rendered-attributes')
        ;
        $container = new class(['default' => static fn () => $renderer]) implements ServiceProviderInterface {
            use ServiceLocatorTrait;
        };
        $streamSourceRenderers = new class([]) implements ServiceProviderInterface {
            use ServiceLocatorTrait;
        };

        $runtime = new TurboRuntime($container, 'default', new TurboFrame(new RequestStack()), $streamSourceRenderers, new IdAccessor());
        $runtime->renderTurboStreamListen($twig, 'a_topic');
    }

    public function testRenderTurboStreamListenWithMultipleHubs(): void
    {
        $twig = $this->createStub(Environment::class);
        $renderer1 = $this->createStub(TurboStreamListenRendererInterface::class);
        $renderer2 = $this->createMock(TurboStreamListenRendererInterface::class);
        $renderer2->expects($this->once())
            ->method('renderTurboStreamListen')
            ->with($twig, 'a_topic', ['hub' => 'hub2'])
            ->willReturn('rendered-attributes')
        ;
        $container = new class(['hub1' => static fn () => $renderer1, 'hub2' => static fn () => $renderer2]) implements ServiceProviderInterface {
            use ServiceLocatorTrait;
        };
        $streamSourceRenderers = new class([]) implements ServiceProviderInterface {
            use ServiceLocatorTrait;
        };

        $runtime = new TurboRuntime($container, 'hub1', new TurboFrame(new RequestStack()), $streamSourceRenderers, new IdAccessor());
        $runtime->renderTurboStreamListen($twig, 'a_topic', 'hub2');
    }

    public function testRenderTurboStreamListenWithDifferentsHub(): void
    {
        $this->expectException(\InvalidArgumentException::class);

        $twig = $this->createStub(Environment::class);
        $renderer = $this->createStub(TurboStreamListenRendererInterface::class);
        $container = new class(['default' => static fn () => $renderer]) implements ServiceProviderInterface {
            use ServiceLocatorTrait;
        };
        $streamSourceRenderers = new class([]) implements ServiceProviderInterface {
            use ServiceLocatorTrait;
        };

        $runtime = new TurboRuntime($container, 'default', new TurboFrame(new RequestStack()), $streamSourceRenderers, new IdAccessor());
        $runtime->renderTurboStreamListen($twig, 'a_topic', 'default', ['hub' => 'hub3']);
    }

    public function testDomIdOfAnEntity(): void
    {
        $this->assertSame('player_42', $this->createRuntime($this->createDoctrineIdAccessor())->domId(new Player(42)));
    }

    public function testDomIdOfAnEntityWithACompositeIdentifier(): void
    {
        $membership = new Membership(new Player(1), new Team(2));

        $this->assertSame('membership_1-2', $this->createRuntime($this->createDoctrineIdAccessor())->domId($membership));
    }

    public function testDomIdOfAnEntityWithAUuidIdentifier(): void
    {
        $ticket = new Ticket(Uuid::fromString('3f0c252d-88d4-449e-b5a9-dd793e393354'));

        $this->assertSame('ticket_3f0c252d-88d4-449e-b5a9-dd793e393354', $this->createRuntime($this->createDoctrineIdAccessor())->domId($ticket));
    }

    public function testDomIdOfAnEntityWithAUlidIdentifier(): void
    {
        $invoice = new Invoice(Ulid::fromString('01ARZ3NDEKTSV4RRFFQ69G5FAV'));

        $this->assertSame('invoice_01ARZ3NDEKTSV4RRFFQ69G5FAV', $this->createRuntime($this->createDoctrineIdAccessor())->domId($invoice));
    }

    public function testDomIdOfAnEntityWithACompositeIdentifierNotSavedYet(): void
    {
        $idAccessor = $this->createStub(IdAccessor::class);
        // IdAccessor joins the identifier of an association not saved yet into an empty string
        $idAccessor->method('getEntityId')->willReturn(['player' => '', 'team' => '2']);

        $membership = new Membership(new Player(1), new Team(2));

        $this->assertSame('new_membership', $this->createRuntime($idAccessor)->domId($membership));
    }

    private function createRuntime(IdAccessor $idAccessor): TurboRuntime
    {
        $locator = new class([]) implements ServiceProviderInterface {
            use ServiceLocatorTrait;
        };

        return new TurboRuntime($locator, 'default', new TurboFrame(new RequestStack()), $locator, $idAccessor);
    }

    private function createDoctrineIdAccessor(): IdAccessor
    {
        $doctrine = $this->createStub(ManagerRegistry::class);
        $doctrine->method('getManagerForClass')->willReturn(EntityManagerFactory::create());

        return new IdAccessor(null, $doctrine);
    }
}
