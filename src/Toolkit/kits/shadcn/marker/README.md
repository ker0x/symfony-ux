# Marker

Displays an inline status, system note, bordered row, or labeled separator in a conversation.

```twig {"preview":true,"height":"300px"}
<div class="flex w-full max-w-sm flex-col gap-8 py-12">
    <twig:Marker>
        <twig:Marker:Icon>
            <twig:ux:icon name="lucide:git-branch" />
        </twig:Marker:Icon>
        <twig:Marker:Content>Switched to a new branch</twig:Marker:Content>
    </twig:Marker>
    <twig:Marker role="status">
        <twig:Marker:Icon>
            <twig:Spinner />
        </twig:Marker:Icon>
        <twig:Marker:Content class="animate-pulse">Thinking...</twig:Marker:Content>
    </twig:Marker>
    <twig:Marker variant="separator">
        <twig:Marker:Content>Conversation compacted</twig:Marker:Content>
    </twig:Marker>
    <twig:Marker>
        <twig:Marker:Icon>
            <twig:ux:icon name="lucide:search" />
        </twig:Marker:Icon>
        <twig:Marker:Content>Explored 4 files</twig:Marker:Content>
    </twig:Marker>
</div>
```

## Installation

::: installation

## Usage

```twig
<twig:Marker variant="default">
    <twig:Marker:Icon>
        <twig:ux:icon name="lucide:check" />
    </twig:Marker:Icon>
    <twig:Marker:Content>Explored 4 files</twig:Marker:Content>
</twig:Marker>
```

`Marker` is presentational by default. Set `role="status"` for streaming or in-progress markers so assistive technologies announce the update, and use the `as` prop to render a real `a` or `button` when the marker is interactive.

## Examples

### Variants

Use the `variant` prop to switch between an inline marker, a bordered row, and a labeled separator.

```twig {"preview":true,"height":"240px"}
<div class="flex w-full max-w-sm flex-col gap-8 py-12">
    <twig:Marker>
        <twig:Marker:Content>A default marker for inline notes.</twig:Marker:Content>
    </twig:Marker>
    <twig:Marker variant="separator">
        <twig:Marker:Content>A separator marker</twig:Marker:Content>
    </twig:Marker>
    <twig:Marker variant="border">
        <twig:Marker:Content>A border marker for row boundaries.</twig:Marker:Content>
    </twig:Marker>
</div>
```

### Status

Set `role="status"` and include a `Spinner` for streaming or in-progress markers so updates are announced.

```twig {"preview":true,"height":"200px"}
<div class="flex w-full max-w-sm flex-col gap-8 py-12">
    <twig:Marker role="status">
        <twig:Marker:Icon>
            <twig:Spinner />
        </twig:Marker:Icon>
        <twig:Marker:Content>Compacting conversation</twig:Marker:Content>
    </twig:Marker>
    <twig:Marker variant="separator" role="status">
        <twig:Marker:Icon>
            <twig:Spinner />
        </twig:Marker:Icon>
        <twig:Marker:Content>Running tests</twig:Marker:Content>
    </twig:Marker>
</div>
```

### Shimmer

Add an animation class to `Marker:Content` for a streaming-text effect. Shadcn ships a dedicated `shimmer` utility in its own package; with plain Tailwind, `animate-pulse` gives the same in-progress cue.

```twig {"preview":true,"height":"200px"}
<div class="flex w-full max-w-sm flex-col gap-8 py-12">
    <twig:Marker role="status">
        <twig:Marker:Content class="animate-pulse">Thinking...</twig:Marker:Content>
    </twig:Marker>
    <twig:Marker variant="separator" role="status">
        <twig:Marker:Content class="animate-pulse">Reading 4 files</twig:Marker:Content>
    </twig:Marker>
</div>
```

### Separator

Use the `separator` variant for labeled dividers, such as dates or section breaks, in a conversation.

```twig {"preview":true,"height":"240px"}
<div class="flex w-full max-w-sm flex-col gap-8 py-12">
    <twig:Marker variant="separator">
        <twig:Marker:Content>Today</twig:Marker:Content>
    </twig:Marker>
    <twig:Marker variant="separator">
        <twig:Marker:Content>Worked for 42s</twig:Marker:Content>
    </twig:Marker>
    <twig:Marker variant="separator">
        <twig:Marker:Content>Conversation compacted</twig:Marker:Content>
    </twig:Marker>
</div>
```

A labeled separator needs no role: the divider lines are decorative CSS pseudo-elements and the text is announced as ordinary content. Do not add `role="separator"` — it takes its accessible name from `aria-label`, so the visible label would not be announced.

### Border

Use the `border` variant for status rows that should keep the default marker alignment while separating the next row.

```twig {"preview":true,"height":"230px"}
<div class="flex w-full max-w-sm flex-col gap-3 py-12">
    <twig:Marker variant="border">
        <twig:Marker:Icon>
            <twig:ux:icon name="lucide:git-branch" />
        </twig:Marker:Icon>
        <twig:Marker:Content>Switched to release-candidate</twig:Marker:Content>
    </twig:Marker>
    <twig:Marker variant="border">
        <twig:Marker:Icon>
            <twig:ux:icon name="lucide:search" />
        </twig:Marker:Icon>
        <twig:Marker:Content>Reviewed 8 related files</twig:Marker:Content>
    </twig:Marker>
    <twig:Marker variant="border">
        <twig:Marker:Icon>
            <twig:ux:icon name="lucide:file-text" />
        </twig:Marker:Icon>
        <twig:Marker:Content>Opened implementation notes</twig:Marker:Content>
    </twig:Marker>
</div>
```

### With Icon

Use `Marker:Icon` to render an icon alongside the content. It is decorative and hidden from assistive technologies, so the adjacent `Marker:Content` carries the meaning. Use `flex-col` to stack the icon above the content.

```twig {"preview":true,"height":"300px"}
<div class="flex w-full max-w-sm flex-col gap-12 py-12">
    <twig:Marker>
        <twig:Marker:Icon>
            <twig:ux:icon name="lucide:git-branch" />
        </twig:Marker:Icon>
        <twig:Marker:Content>Switched to a new branch</twig:Marker:Content>
    </twig:Marker>
    <twig:Marker variant="separator">
        <twig:Marker:Icon>
            <twig:ux:icon name="lucide:search" />
        </twig:Marker:Icon>
        <twig:Marker:Content>Explored 4 files</twig:Marker:Content>
    </twig:Marker>
    <twig:Marker class="flex-col">
        <twig:Marker:Icon>
            <twig:ux:icon name="lucide:book-open-check" />
        </twig:Marker:Icon>
        <twig:Marker:Content>Syncing completed</twig:Marker:Content>
    </twig:Marker>
</div>
```

### Links and Buttons

Turn a marker into a link or a button with the `as` prop on `Marker`, so it is focusable and exposes the correct role. The accessible name comes from the marker text.

```twig {"preview":true,"height":"200px"}
<div class="flex w-full max-w-sm flex-col gap-8 py-12">
    <twig:Marker as="a" href="#links-and-buttons">
        <twig:Marker:Icon>
            <twig:ux:icon name="lucide:git-branch" />
        </twig:Marker:Icon>
        <twig:Marker:Content>View the pull request</twig:Marker:Content>
    </twig:Marker>
    <twig:Marker as="button" type="button" class="transition-colors hover:text-foreground">
        <twig:Marker:Icon>
            <twig:ux:icon name="lucide:rotate-ccw" />
        </twig:Marker:Icon>
        <twig:Marker:Content>Revert this change</twig:Marker:Content>
    </twig:Marker>
</div>
```

### RTL

To enable RTL support, set the `dir="rtl"` attribute on the root element.

```twig {"preview":true,"height":"420px"}
<div class="flex w-full flex-col items-center gap-4">
    {# Arabic #}
    <div class="flex w-full max-w-sm flex-col gap-6 py-6" dir="rtl">
        <twig:Marker>
            <twig:Marker:Icon>
                <twig:ux:icon name="lucide:git-branch" />
            </twig:Marker:Icon>
            <twig:Marker:Content>تم التبديل إلى فرع جديد</twig:Marker:Content>
        </twig:Marker>
        <twig:Marker variant="separator">
            <twig:Marker:Content>تم ضغط المحادثة</twig:Marker:Content>
        </twig:Marker>
        <twig:Marker variant="border">
            <twig:Marker:Icon>
                <twig:ux:icon name="lucide:search" />
            </twig:Marker:Icon>
            <twig:Marker:Content>تم استكشاف 4 ملفات</twig:Marker:Content>
        </twig:Marker>
    </div>

    {# Hebrew #}
    <div class="flex w-full max-w-sm flex-col gap-6 py-6" dir="rtl">
        <twig:Marker>
            <twig:Marker:Icon>
                <twig:ux:icon name="lucide:git-branch" />
            </twig:Marker:Icon>
            <twig:Marker:Content>עברת לענף חדש</twig:Marker:Content>
        </twig:Marker>
        <twig:Marker variant="separator">
            <twig:Marker:Content>השיחה כווצה</twig:Marker:Content>
        </twig:Marker>
        <twig:Marker variant="border">
            <twig:Marker:Icon>
                <twig:ux:icon name="lucide:search" />
            </twig:Marker:Icon>
            <twig:Marker:Content>נסרקו 4 קבצים</twig:Marker:Content>
        </twig:Marker>
    </div>
</div>
```

## API Reference

::: api-reference
