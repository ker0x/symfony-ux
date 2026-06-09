Symfony UX Share Link
=====================

**EXPERIMENTAL** This component is currently experimental and is likely
to change, or even change drastically.

Symfony UX ShareLink is a Symfony bundle that generates share links for
the major social platforms (Email via ``mailto:``, Facebook, X, LinkedIn,
Threads, WhatsApp, Telegram, Reddit, Pinterest, Bluesky and Mastodon) so
visitors can share any page or piece of content in one click.

Installation
------------

Install the bundle using Composer and Symfony Flex:

.. code-block:: terminal

    $ composer require symfony/ux-share-link

Usage
-----

Start by creating a ``Shareable`` object in your controller. Once populated with the URL and any optional metadata you want pre-filled (title, text, hashtags, etc.), pass it to Twig to render the share links::

    // src/Controller/ArticleController.php
    namespace App\Controller;

    use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
    use Symfony\Component\HttpFoundation\Response;
    use Symfony\Component\Routing\Attribute\Route;
    use Symfony\UX\ShareLink\Shareable;

    final class ArticleController extends AbstractController
    {
        #[Route('/article/{slug}', name: 'app_article_show')]
        public function show(): Response
        {
            $shareable = new Shareable(
                url: 'https://symfony.com/blog/symfony-ux-share-link',
                title: 'Introducing Symfony UX Share Link',
                text: 'Generate share buttons for the major social platforms in one Twig call.',
                hashtags: ['symfony', 'ux', 'php'],
                via: 'symfony',
            );

            return $this->render('article/show.html.twig', ['shareable' => $shareable]);
        }
    }

Then use the two Twig functions to render links:

* ``ux_share_link(shareable, provider)``: generates a link for one provider
* ``ux_share_links(shareable)``: generates links for every registered provider

.. code-block:: html+twig

    {# templates/article/show.html.twig #}
    <a href="{{ ux_share_link(shareable, 'x').url }}" target="_blank" rel="noopener">
        Share on X
    </a>

    <ul class="share-buttons">
        {% for link in ux_share_links(shareable) %}
            <li><a href="{{ link.url }}" target="_blank" rel="noopener">{{ link.label }}</a></li>
        {% endfor %}
    </ul>

Supported providers
-------------------

============= ======= ========== ===== ========== ========= ========== ========== ======== ============ ========== ===========
Field         Email   Facebook   X     LinkedIn   Threads   WhatsApp   Telegram   Reddit   Pinterest    Bluesky    Mastodon
============= ======= ========== ===== ========== ========= ========== ========== ======== ============ ========== ===========
url           yes     yes        yes   yes        yes       yes        yes        yes      yes          yes        yes
title         yes     yes        yes   -          yes       yes        yes        yes      yes          yes        yes
text          yes     yes        yes   -          yes       yes        yes        -        yes          yes        yes
hashtags      -       -          yes   -          -         -          -          -        -            -          -
via           -       -          yes   -          -         -          -          -        -            -          -
to            yes     -          -     -          -         -          -          -        -            -          -
============= ======= ========== ===== ========== ========= ========== ========== ======== ============ ========== ===========

Fields marked ``-`` are silently ignored when generating a link for that
provider, because the provider's URL scheme does not support them. For example,
the LinkedIn ``share-offsite`` endpoint only honours the URL and pulls the
title/summary/preview image from the destination page's Open Graph metadata.

Provider-specific notes
~~~~~~~~~~~~~~~~~~~~~~~

* **Email** — produces a ``mailto:`` URL. ``title`` becomes the subject;
  ``text`` is the body (the URL is appended on its own line). ``to`` becomes
  the recipient — omit it to let the user pick a recipient.
* **Facebook** — uses ``sharer.php`` with ``u`` (URL) and an optional ``quote``
  (taken from ``text`` if set, otherwise ``title``).
* **X** — uses the ``intent/tweet`` endpoint. ``hashtags`` are joined with
  commas. A leading ``@`` in ``via`` is stripped.
* **LinkedIn** — uses ``sharing/share-offsite``, which only accepts ``url``.
* **Threads**, **WhatsApp**, **Bluesky** and **Mastodon** — these endpoints
  accept a single ``text`` parameter, into which the ``title`` (or ``text``)
  and ``url`` are folded with a space separator.
* **Telegram** — uses ``t.me/share/url`` with separate ``url`` and ``text``
  parameters.
* **Reddit** — uses ``reddit.com/submit`` with separate ``url`` and ``title``
  parameters.
* **Pinterest** — uses ``pinterest.com/pin/create/button``. Pinterest scrapes
  the destination page for a pinnable image, so make sure your page exposes
  Open Graph image metadata.
* **Mastodon** — Mastodon is federated, so the share dialog must point at the
  user's home instance. The provider defaults to ``mastodon.social``; override
  it in your services configuration to target another instance::

      # config/services.yaml
      services:
          ux_share_link.provider.mastodon:
              class: Symfony\UX\ShareLink\Provider\MastodonShareLinkProvider
              arguments: ['fosstodon.org']
              tags: ['ux_share_link.provider']

Backward compatibility promise
------------------------------

This bundle follows the same backward-compatibility promise as
`Symfony itself <https://symfony.com/doc/current/contributing/code/bc.html>`_.
