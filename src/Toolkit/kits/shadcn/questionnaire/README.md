# Questionnaire

A multi-step questionnaire with single-choice, multiple-choice, freeform, and skippable questions.

```twig {"preview":true,"height":"560px"}
<twig:Questionnaire id="demo" defaultItem="direction" shortcuts="letters" class="mx-auto max-w-md">
    <twig:Questionnaire:Progress />

    <twig:Questionnaire:Item name="direction" required>
        <twig:Questionnaire:Title>What should the agent build next?</twig:Questionnaire:Title>
        <twig:Questionnaire:Description>Choose a direction or describe another task.</twig:Questionnaire:Description>
        <twig:Questionnaire:Choices>
            <twig:Questionnaire:Choice value="tool-calls">
                <span class="font-medium">Tool call timeline</span>
                <twig:Questionnaire:ChoiceDescription>Show what the agent ran and what came back.</twig:Questionnaire:ChoiceDescription>
            </twig:Questionnaire:Choice>
            <twig:Questionnaire:Choice value="approvals">
                <span class="font-medium">Approval checkpoints</span>
                <twig:Questionnaire:ChoiceDescription>Ask before sensitive or destructive actions.</twig:Questionnaire:ChoiceDescription>
            </twig:Questionnaire:Choice>
            <twig:Questionnaire:Choice value="handoffs">
                <span class="font-medium">Sub-agent handoffs</span>
                <twig:Questionnaire:ChoiceDescription>Make delegated work and results easier to follow.</twig:Questionnaire:ChoiceDescription>
            </twig:Questionnaire:Choice>
            <twig:Questionnaire:Input aria-label="Another agent feature" placeholder="Describe another feature…" />
        </twig:Questionnaire:Choices>
        <twig:Questionnaire:Error />
    </twig:Questionnaire:Item>

    <twig:Questionnaire:Item name="signals" multiple>
        <twig:Questionnaire:Title>What should every progress update include?</twig:Questionnaire:Title>
        <twig:Questionnaire:Description>Select all that apply, or skip this question.</twig:Questionnaire:Description>
        <twig:Questionnaire:Choices>
            <twig:Questionnaire:Choice value="progress">Progress</twig:Questionnaire:Choice>
            <twig:Questionnaire:Choice value="decisions">Decisions</twig:Questionnaire:Choice>
            <twig:Questionnaire:Choice value="risks">Risks</twig:Questionnaire:Choice>
            <twig:Questionnaire:Choice value="next-step">Next step</twig:Questionnaire:Choice>
        </twig:Questionnaire:Choices>
        <twig:Questionnaire:Error />
    </twig:Questionnaire:Item>

    <twig:Questionnaire:Item name="timing" required>
        <twig:Questionnaire:Title>When should work begin?</twig:Questionnaire:Title>
        <twig:Questionnaire:Description>Choose when the agent should begin the work.</twig:Questionnaire:Description>
        <twig:Questionnaire:Choices>
            <twig:Questionnaire:Choice value="now">Start now</twig:Questionnaire:Choice>
            <twig:Questionnaire:Choice value="next-cycle">Next development cycle</twig:Questionnaire:Choice>
            <twig:Questionnaire:Choice value="backlog">Add it to the backlog</twig:Questionnaire:Choice>
        </twig:Questionnaire:Choices>
        <twig:Questionnaire:Error />
    </twig:Questionnaire:Item>

    <twig:Questionnaire:Actions>
        <twig:Questionnaire:Previous />
        <twig:Questionnaire:Skip />
        <twig:Questionnaire:Next />
        <twig:Questionnaire:Submit>Save plan</twig:Questionnaire:Submit>
    </twig:Questionnaire:Actions>
</twig:Questionnaire>
```

## Installation

::: installation

## Usage

```twig
<twig:Questionnaire defaultItem="direction" shortcuts="letters">
    <twig:Questionnaire:Progress />

    <twig:Questionnaire:Item name="direction" required>
        <twig:Questionnaire:Title>What should we prototype next?</twig:Questionnaire:Title>
        <twig:Questionnaire:Description>Choose a direction or write your own.</twig:Questionnaire:Description>
        <twig:Questionnaire:Choices>
            <twig:Questionnaire:Choice value="delegation">Delegation</twig:Questionnaire:Choice>
            <twig:Questionnaire:Choice value="questions">Question prompts</twig:Questionnaire:Choice>
            <twig:Questionnaire:Input aria-label="Another answer" placeholder="Type another answer…" />
        </twig:Questionnaire:Choices>
        <twig:Questionnaire:Error />
    </twig:Questionnaire:Item>

    <twig:Questionnaire:Actions>
        <twig:Questionnaire:Previous />
        <twig:Questionnaire:Skip />
        <twig:Questionnaire:Next />
        <twig:Questionnaire:Submit />
    </twig:Questionnaire:Actions>
</twig:Questionnaire>
```

`Questionnaire` renders a `form`, so answers are submitted with the name of each `Questionnaire:Item`. An item marked `multiple` submits an array, and its inputs are named `<name>[]`.

`Questionnaire` owns the ordered items, the active item, validation, progress, and navigation. The containing page, card, or dialog owns cancellation, persistence, and transport.

## Examples

### Multiple Selection

Use the `multiple` prop for an item that accepts more than one fixed answer.

```twig {"preview":true,"height":"420px"}
<twig:Questionnaire id="multiple" defaultItem="context" shortcuts="letters" class="mx-auto max-w-md">
    <twig:Questionnaire:Item name="context" multiple required>
        <twig:Questionnaire:Title>What context should the agent inspect?</twig:Questionnaire:Title>
        <twig:Questionnaire:Description>Select every source that may affect the implementation.</twig:Questionnaire:Description>
        <twig:Questionnaire:Choices>
            <twig:Questionnaire:Choice value="source">Relevant source files</twig:Questionnaire:Choice>
            <twig:Questionnaire:Choice value="tests">Existing tests</twig:Questionnaire:Choice>
            <twig:Questionnaire:Choice value="docs">Architecture documentation</twig:Questionnaire:Choice>
            <twig:Questionnaire:Choice value="history">Recent commit history</twig:Questionnaire:Choice>
        </twig:Questionnaire:Choices>
        <twig:Questionnaire:Error />
    </twig:Questionnaire:Item>

    <twig:Questionnaire:Actions>
        <twig:Questionnaire:Submit>Share context</twig:Questionnaire:Submit>
    </twig:Questionnaire:Actions>
</twig:Questionnaire>
```

### Freeform Answer

Compose `Questionnaire:Input` with fixed choices when the user can provide another answer. The input and the choices share the item name, so answering one clears the other.

```twig {"preview":true,"height":"420px"}
<twig:Questionnaire id="freeform" defaultItem="approach" shortcuts="letters" class="mx-auto max-w-md">
    <twig:Questionnaire:Item name="approach" required>
        <twig:Questionnaire:Title>How should the agent approach this refactor?</twig:Questionnaire:Title>
        <twig:Questionnaire:Description>Choose a strategy or write a more specific instruction.</twig:Questionnaire:Description>
        <twig:Questionnaire:Choices>
            <twig:Questionnaire:Choice value="incremental">Make the smallest safe change</twig:Questionnaire:Choice>
            <twig:Questionnaire:Choice value="module">Refactor one module at a time</twig:Questionnaire:Choice>
            <twig:Questionnaire:Choice value="rewrite">Replace the implementation completely</twig:Questionnaire:Choice>
            <twig:Questionnaire:Input aria-label="Another refactoring approach" placeholder="Describe another approach…" />
        </twig:Questionnaire:Choices>
        <twig:Questionnaire:Error />
    </twig:Questionnaire:Item>

    <twig:Questionnaire:Actions>
        <twig:Questionnaire:Submit>Use this approach</twig:Questionnaire:Submit>
    </twig:Questionnaire:Actions>
</twig:Questionnaire>
```

### Explicit Skip

Add `Questionnaire:Skip` when an optional item may be intentionally left unanswered. The button only appears on items that are not `required`.

```twig {"preview":true,"height":"520px"}
<twig:Questionnaire id="skip" defaultItem="task" class="mx-auto max-w-md">
    <twig:Questionnaire:Progress />

    <twig:Questionnaire:Item name="task" required>
        <twig:Questionnaire:Title>What kind of change is this?</twig:Questionnaire:Title>
        <twig:Questionnaire:Description>Choose the category that best describes the work.</twig:Questionnaire:Description>
        <twig:Questionnaire:Choices>
            <twig:Questionnaire:Choice value="feature">New feature</twig:Questionnaire:Choice>
            <twig:Questionnaire:Choice value="fix">Bug fix</twig:Questionnaire:Choice>
            <twig:Questionnaire:Choice value="refactor">Refactor</twig:Questionnaire:Choice>
        </twig:Questionnaire:Choices>
        <twig:Questionnaire:Error />
    </twig:Questionnaire:Item>

    <twig:Questionnaire:Item name="constraints">
        <twig:Questionnaire:Title>Are there any implementation constraints?</twig:Questionnaire:Title>
        <twig:Questionnaire:Description>Answer if needed, or intentionally skip this question.</twig:Questionnaire:Description>
        <twig:Questionnaire:Choices>
            <twig:Questionnaire:Choice value="no-dependencies">Do not add dependencies</twig:Questionnaire:Choice>
            <twig:Questionnaire:Choice value="no-migrations">Do not change the database</twig:Questionnaire:Choice>
            <twig:Questionnaire:Choice value="preserve-api">Preserve the public API</twig:Questionnaire:Choice>
            <twig:Questionnaire:Input aria-label="Another implementation constraint" placeholder="Describe another constraint…" />
        </twig:Questionnaire:Choices>
    </twig:Questionnaire:Item>

    <twig:Questionnaire:Item name="review" required>
        <twig:Questionnaire:Title>How should the work be reviewed?</twig:Questionnaire:Title>
        <twig:Questionnaire:Description>Choose the checks the agent should complete before handoff.</twig:Questionnaire:Description>
        <twig:Questionnaire:Choices>
            <twig:Questionnaire:Choice value="tests">Run the test suite</twig:Questionnaire:Choice>
            <twig:Questionnaire:Choice value="diff">Review the final diff</twig:Questionnaire:Choice>
            <twig:Questionnaire:Choice value="both">Tests and diff review</twig:Questionnaire:Choice>
        </twig:Questionnaire:Choices>
        <twig:Questionnaire:Error />
    </twig:Questionnaire:Item>

    <twig:Questionnaire:Actions>
        <twig:Questionnaire:Previous />
        <twig:Questionnaire:Skip />
        <twig:Questionnaire:Next />
        <twig:Questionnaire:Submit>Submit brief</twig:Questionnaire:Submit>
    </twig:Questionnaire:Actions>
</twig:Questionnaire>
```

### Shortcuts

Assign a letter or number key to each answer with the `shortcuts` prop. Press the key to select the matching choice.

```twig {"preview":true,"height":"480px"}
<div class="mx-auto flex w-full max-w-md flex-col gap-8">
    <twig:Questionnaire id="shortcuts-letters" defaultItem="action" shortcuts="letters">
        <twig:Questionnaire:Item name="action" required>
            <twig:Questionnaire:Title>What should the agent do next?</twig:Questionnaire:Title>
            <twig:Questionnaire:Description>Use the displayed shortcut or navigate with the keyboard.</twig:Questionnaire:Description>
            <twig:Questionnaire:Choices>
                <twig:Questionnaire:Choice value="inspect">Inspect the implementation</twig:Questionnaire:Choice>
                <twig:Questionnaire:Choice value="tests">Run the relevant tests</twig:Questionnaire:Choice>
                <twig:Questionnaire:Choice value="patch">Prepare the patch</twig:Questionnaire:Choice>
            </twig:Questionnaire:Choices>
            <twig:Questionnaire:Error />
        </twig:Questionnaire:Item>

        <twig:Questionnaire:Actions>
            <twig:Questionnaire:Submit>Confirm action</twig:Questionnaire:Submit>
        </twig:Questionnaire:Actions>
    </twig:Questionnaire>

    <twig:Questionnaire id="shortcuts-numbers" defaultItem="scope" shortcuts="numbers">
        <twig:Questionnaire:Item name="scope" required>
            <twig:Questionnaire:Title>How much of the codebase may change?</twig:Questionnaire:Title>
            <twig:Questionnaire:Description>The same questionnaire with numbered shortcuts.</twig:Questionnaire:Description>
            <twig:Questionnaire:Choices>
                <twig:Questionnaire:Choice value="file">A single file</twig:Questionnaire:Choice>
                <twig:Questionnaire:Choice value="package">One package</twig:Questionnaire:Choice>
                <twig:Questionnaire:Choice value="workspace">The whole workspace</twig:Questionnaire:Choice>
            </twig:Questionnaire:Choices>
            <twig:Questionnaire:Error />
        </twig:Questionnaire:Item>

        <twig:Questionnaire:Actions>
            <twig:Questionnaire:Submit>Confirm scope</twig:Questionnaire:Submit>
        </twig:Questionnaire:Actions>
    </twig:Questionnaire>
</div>
```

### Custom Validation

Fill `Questionnaire:Error` with your own message to replace the default one shown when a required item has no answer.

```twig {"preview":true,"height":"520px"}
<twig:Questionnaire id="validation" defaultItem="detail" class="mx-auto max-w-md">
    <twig:Questionnaire:Progress />

    <twig:Questionnaire:Item name="detail" required>
        <twig:Questionnaire:Title>How detailed should the answer be?</twig:Questionnaire:Title>
        <twig:Questionnaire:Description>The error below replaces the default validation message.</twig:Questionnaire:Description>
        <twig:Questionnaire:Choices>
            <twig:Questionnaire:Choice value="summary">A short summary</twig:Questionnaire:Choice>
            <twig:Questionnaire:Choice value="walkthrough">A full walkthrough</twig:Questionnaire:Choice>
        </twig:Questionnaire:Choices>
        <twig:Questionnaire:Error>Pick a level of detail before continuing.</twig:Questionnaire:Error>
    </twig:Questionnaire:Item>

    <twig:Questionnaire:Item name="audience" required>
        <twig:Questionnaire:Title>Who will read the answer?</twig:Questionnaire:Title>
        <twig:Questionnaire:Description>Each item can carry its own message.</twig:Questionnaire:Description>
        <twig:Questionnaire:Choices>
            <twig:Questionnaire:Choice value="reviewer">A reviewer</twig:Questionnaire:Choice>
            <twig:Questionnaire:Choice value="maintainer">A maintainer</twig:Questionnaire:Choice>
        </twig:Questionnaire:Choices>
        <twig:Questionnaire:Error>Tell us who the answer is for.</twig:Questionnaire:Error>
    </twig:Questionnaire:Item>

    <twig:Questionnaire:Actions>
        <twig:Questionnaire:Previous />
        <twig:Questionnaire:Next />
        <twig:Questionnaire:Submit>Save answers</twig:Questionnaire:Submit>
    </twig:Questionnaire:Actions>
</twig:Questionnaire>
```

### Controlled

Use the `defaultItem` prop to render a questionnaire that opens on a specific item, such as the one a server-side validation marked invalid.

```twig {"preview":true,"height":"520px"}
<twig:Questionnaire id="controlled" defaultItem="checks" class="mx-auto max-w-md">
    <twig:Questionnaire:Progress />

    <twig:Questionnaire:Item name="scope" required>
        <twig:Questionnaire:Title>What may the agent change?</twig:Questionnaire:Title>
        <twig:Questionnaire:Choices>
            <twig:Questionnaire:Choice value="component">One component</twig:Questionnaire:Choice>
            <twig:Questionnaire:Choice value="tests">Tests only</twig:Questionnaire:Choice>
            <twig:Questionnaire:Choice value="feature">A whole feature</twig:Questionnaire:Choice>
        </twig:Questionnaire:Choices>
        <twig:Questionnaire:Error />
    </twig:Questionnaire:Item>

    <twig:Questionnaire:Item name="checks" required>
        <twig:Questionnaire:Title>Which checks should run before handoff?</twig:Questionnaire:Title>
        <twig:Questionnaire:Description>This questionnaire opens here instead of on the first item.</twig:Questionnaire:Description>
        <twig:Questionnaire:Choices>
            <twig:Questionnaire:Choice value="targeted">Targeted tests</twig:Questionnaire:Choice>
            <twig:Questionnaire:Choice value="package">Package suite</twig:Questionnaire:Choice>
            <twig:Questionnaire:Choice value="full">Full workspace</twig:Questionnaire:Choice>
        </twig:Questionnaire:Choices>
        <twig:Questionnaire:Error />
    </twig:Questionnaire:Item>

    <twig:Questionnaire:Actions>
        <twig:Questionnaire:Previous />
        <twig:Questionnaire:Next />
        <twig:Questionnaire:Submit>Save answers</twig:Questionnaire:Submit>
    </twig:Questionnaire:Actions>
</twig:Questionnaire>
```

### Resume

Restore a saved session by combining `defaultItem` with the `checked` prop on the answers that were already given.

```twig {"preview":true,"height":"520px"}
<twig:Questionnaire id="resume" defaultItem="verification" class="mx-auto max-w-md">
    <twig:Questionnaire:Progress />

    <twig:Questionnaire:Item name="change" required>
        <twig:Questionnaire:Title>What kind of migration is this?</twig:Questionnaire:Title>
        <twig:Questionnaire:Description>This answer was restored from the saved session.</twig:Questionnaire:Description>
        <twig:Questionnaire:Choices>
            <twig:Questionnaire:Choice value="incremental" checked>Incremental migration</twig:Questionnaire:Choice>
            <twig:Questionnaire:Choice value="cutover">One-time cutover</twig:Questionnaire:Choice>
        </twig:Questionnaire:Choices>
        <twig:Questionnaire:Error />
    </twig:Questionnaire:Item>

    <twig:Questionnaire:Item name="verification" multiple required>
        <twig:Questionnaire:Title>How should the migration be verified?</twig:Questionnaire:Title>
        <twig:Questionnaire:Description>Two answers were already selected before the session was saved.</twig:Questionnaire:Description>
        <twig:Questionnaire:Choices>
            <twig:Questionnaire:Choice value="tests" checked>Automated tests</twig:Questionnaire:Choice>
            <twig:Questionnaire:Choice value="typecheck" checked>Type checking</twig:Questionnaire:Choice>
            <twig:Questionnaire:Choice value="manual">Manual review</twig:Questionnaire:Choice>
        </twig:Questionnaire:Choices>
        <twig:Questionnaire:Error />
    </twig:Questionnaire:Item>

    <twig:Questionnaire:Item name="notes">
        <twig:Questionnaire:Title>Anything else to carry over?</twig:Questionnaire:Title>
        <twig:Questionnaire:Choices>
            <twig:Questionnaire:Input aria-label="Migration notes" placeholder="Add a note…" />
        </twig:Questionnaire:Choices>
    </twig:Questionnaire:Item>

    <twig:Questionnaire:Actions>
        <twig:Questionnaire:Previous />
        <twig:Questionnaire:Skip />
        <twig:Questionnaire:Next />
        <twig:Questionnaire:Submit>Resume run</twig:Questionnaire:Submit>
    </twig:Questionnaire:Actions>
</twig:Questionnaire>
```

### Conditional Items

Mark an item `disabled` when it does not apply to the user's earlier answers: it is inert and navigation steps over it.

```twig {"preview":true,"height":"520px"}
<twig:Questionnaire id="conditional" defaultItem="runtime" class="mx-auto max-w-md">
    <twig:Questionnaire:Progress />

    <twig:Questionnaire:Item name="runtime" required>
        <twig:Questionnaire:Title>Where should the agent run?</twig:Questionnaire:Title>
        <twig:Questionnaire:Description>The sandbox question only applies to cloud runs.</twig:Questionnaire:Description>
        <twig:Questionnaire:Choices>
            <twig:Questionnaire:Choice value="local">On this machine</twig:Questionnaire:Choice>
            <twig:Questionnaire:Choice value="cloud">In the cloud</twig:Questionnaire:Choice>
        </twig:Questionnaire:Choices>
        <twig:Questionnaire:Error />
    </twig:Questionnaire:Item>

    <twig:Questionnaire:Item name="sandbox" required disabled>
        <twig:Questionnaire:Title>Which sandbox should the cloud run use?</twig:Questionnaire:Title>
        <twig:Questionnaire:Choices>
            <twig:Questionnaire:Choice value="preview">Preview</twig:Questionnaire:Choice>
            <twig:Questionnaire:Choice value="staging">Staging</twig:Questionnaire:Choice>
            <twig:Questionnaire:Choice value="isolated">Fully isolated</twig:Questionnaire:Choice>
        </twig:Questionnaire:Choices>
        <twig:Questionnaire:Error />
    </twig:Questionnaire:Item>

    <twig:Questionnaire:Item name="approval" required>
        <twig:Questionnaire:Title>When should the agent ask for approval?</twig:Questionnaire:Title>
        <twig:Questionnaire:Choices>
            <twig:Questionnaire:Choice value="always">Before every action</twig:Questionnaire:Choice>
            <twig:Questionnaire:Choice value="destructive">Before destructive actions</twig:Questionnaire:Choice>
            <twig:Questionnaire:Choice value="never">Never</twig:Questionnaire:Choice>
        </twig:Questionnaire:Choices>
        <twig:Questionnaire:Error />
    </twig:Questionnaire:Item>

    <twig:Questionnaire:Actions>
        <twig:Questionnaire:Previous />
        <twig:Questionnaire:Next />
        <twig:Questionnaire:Submit>Start run</twig:Questionnaire:Submit>
    </twig:Questionnaire:Actions>
</twig:Questionnaire>
```

### Navigation State

Each `Questionnaire:Item` exposes `data-status`, so answered and skipped questions can be styled differently from unanswered ones.

```twig {"preview":true,"height":"480px"}
<twig:Questionnaire id="navigation-state" defaultItem="permissions" class="mx-auto max-w-md">
    <twig:Questionnaire:Progress />

    <twig:Questionnaire:Item
        name="permissions"
        required
        class="rounded-lg border border-dashed border-border p-4 data-[status=answered]:border-solid data-[status=answered]:border-primary/40"
    >
        <twig:Questionnaire:Title>What may the agent modify?</twig:Questionnaire:Title>
        <twig:Questionnaire:Description>The dashed border becomes solid once this question is answered.</twig:Questionnaire:Description>
        <twig:Questionnaire:Choices>
            <twig:Questionnaire:Choice value="files">Project files</twig:Questionnaire:Choice>
            <twig:Questionnaire:Choice value="tests">Tests only</twig:Questionnaire:Choice>
            <twig:Questionnaire:Choice value="config">Configuration</twig:Questionnaire:Choice>
        </twig:Questionnaire:Choices>
        <twig:Questionnaire:Error />
    </twig:Questionnaire:Item>

    <twig:Questionnaire:Item
        name="checks"
        class="rounded-lg border border-dashed border-border p-4 data-[status=answered]:border-solid data-[status=answered]:border-primary/40 data-[status=skipped]:opacity-60"
    >
        <twig:Questionnaire:Title>Which checks should the agent run?</twig:Questionnaire:Title>
        <twig:Questionnaire:Description>Skipping this question dims it instead.</twig:Questionnaire:Description>
        <twig:Questionnaire:Choices>
            <twig:Questionnaire:Choice value="tests">Tests</twig:Questionnaire:Choice>
            <twig:Questionnaire:Choice value="types">Type checking</twig:Questionnaire:Choice>
            <twig:Questionnaire:Choice value="all">Everything</twig:Questionnaire:Choice>
        </twig:Questionnaire:Choices>
        <twig:Questionnaire:Error />
    </twig:Questionnaire:Item>

    <twig:Questionnaire:Actions>
        <twig:Questionnaire:Previous />
        <twig:Questionnaire:Skip />
        <twig:Questionnaire:Next />
        <twig:Questionnaire:Submit>Confirm</twig:Questionnaire:Submit>
    </twig:Questionnaire:Actions>
</twig:Questionnaire>
```

### Custom Progress

Replace the content of `Questionnaire:Progress` to build a custom indicator. Elements marked `data-questionnaire-target="progressStep"` receive `data-active`, and `progressCurrent` / `progressTotal` receive the step numbers.

```twig {"preview":true,"height":"520px"}
<twig:Questionnaire id="custom-progress" defaultItem="scope" class="mx-auto max-w-md">
    <twig:Questionnaire:Progress class="w-full">
        <div class="mb-2 flex gap-1.5" aria-hidden="true">
            <span data-questionnaire-target="progressStep" class="h-1.5 flex-1 rounded-full bg-muted data-[active=true]:bg-primary"></span>
            <span data-questionnaire-target="progressStep" class="h-1.5 flex-1 rounded-full bg-muted data-[active=true]:bg-primary"></span>
            <span data-questionnaire-target="progressStep" class="h-1.5 flex-1 rounded-full bg-muted data-[active=true]:bg-primary"></span>
        </div>
        <span>Checkpoint <span data-questionnaire-target="progressCurrent">1</span> of <span data-questionnaire-target="progressTotal">3</span></span>
    </twig:Questionnaire:Progress>

    <twig:Questionnaire:Item name="scope" required>
        <twig:Questionnaire:Title>How large is the change?</twig:Questionnaire:Title>
        <twig:Questionnaire:Choices>
            <twig:Questionnaire:Choice value="small">Small patch</twig:Questionnaire:Choice>
            <twig:Questionnaire:Choice value="medium">Feature-sized change</twig:Questionnaire:Choice>
            <twig:Questionnaire:Choice value="large">Cross-package change</twig:Questionnaire:Choice>
        </twig:Questionnaire:Choices>
        <twig:Questionnaire:Error />
    </twig:Questionnaire:Item>

    <twig:Questionnaire:Item name="strategy" required>
        <twig:Questionnaire:Title>How should commits be organized?</twig:Questionnaire:Title>
        <twig:Questionnaire:Choices>
            <twig:Questionnaire:Choice value="single">Single commit</twig:Questionnaire:Choice>
            <twig:Questionnaire:Choice value="logical">Logical commits</twig:Questionnaire:Choice>
            <twig:Questionnaire:Choice value="squash">Squash before review</twig:Questionnaire:Choice>
        </twig:Questionnaire:Choices>
        <twig:Questionnaire:Error />
    </twig:Questionnaire:Item>

    <twig:Questionnaire:Item name="delivery" required>
        <twig:Questionnaire:Title>How should the work be delivered?</twig:Questionnaire:Title>
        <twig:Questionnaire:Choices>
            <twig:Questionnaire:Choice value="patch">Patch only</twig:Questionnaire:Choice>
            <twig:Questionnaire:Choice value="commit">Committed locally</twig:Questionnaire:Choice>
            <twig:Questionnaire:Choice value="branch">Push a review branch</twig:Questionnaire:Choice>
        </twig:Questionnaire:Choices>
        <twig:Questionnaire:Error />
    </twig:Questionnaire:Item>

    <twig:Questionnaire:Actions>
        <twig:Questionnaire:Previous />
        <twig:Questionnaire:Next />
        <twig:Questionnaire:Submit>Finish plan</twig:Questionnaire:Submit>
    </twig:Questionnaire:Actions>
</twig:Questionnaire>
```

### Animated Items

Animate the active item with `data-[active=true]` while progress and navigation stay stationary.

```twig {"preview":true,"height":"520px"}
<twig:Questionnaire id="animated" defaultItem="task" class="mx-auto max-w-md">
    <twig:Questionnaire:Progress />

    <twig:Questionnaire:Item
        name="task"
        required
        class="data-[active=true]:animate-in data-[active=true]:fade-in-0 data-[active=true]:slide-in-from-bottom-2 data-[active=true]:duration-300 motion-reduce:animate-none"
    >
        <twig:Questionnaire:Title>What should the agent do?</twig:Questionnaire:Title>
        <twig:Questionnaire:Description>Each item fades and slides in as it becomes active.</twig:Questionnaire:Description>
        <twig:Questionnaire:Choices>
            <twig:Questionnaire:Choice value="implement">Implement the change</twig:Questionnaire:Choice>
            <twig:Questionnaire:Choice value="debug">Debug the failure</twig:Questionnaire:Choice>
            <twig:Questionnaire:Choice value="review">Review the diff</twig:Questionnaire:Choice>
        </twig:Questionnaire:Choices>
        <twig:Questionnaire:Error />
    </twig:Questionnaire:Item>

    <twig:Questionnaire:Item
        name="review"
        required
        class="data-[active=true]:animate-in data-[active=true]:fade-in-0 data-[active=true]:slide-in-from-bottom-2 data-[active=true]:duration-300 motion-reduce:animate-none"
    >
        <twig:Questionnaire:Title>How much should be reviewed?</twig:Questionnaire:Title>
        <twig:Questionnaire:Choices>
            <twig:Questionnaire:Choice value="targeted">The touched files</twig:Questionnaire:Choice>
            <twig:Questionnaire:Choice value="complete">The complete diff</twig:Questionnaire:Choice>
            <twig:Questionnaire:Choice value="manual">A manual walkthrough</twig:Questionnaire:Choice>
        </twig:Questionnaire:Choices>
        <twig:Questionnaire:Error />
    </twig:Questionnaire:Item>

    <twig:Questionnaire:Item
        name="delivery"
        required
        class="data-[active=true]:animate-in data-[active=true]:fade-in-0 data-[active=true]:slide-in-from-bottom-2 data-[active=true]:duration-300 motion-reduce:animate-none"
    >
        <twig:Questionnaire:Title>How should the result be delivered?</twig:Questionnaire:Title>
        <twig:Questionnaire:Choices>
            <twig:Questionnaire:Choice value="summary">A short summary</twig:Questionnaire:Choice>
            <twig:Questionnaire:Choice value="branch">A review branch</twig:Questionnaire:Choice>
        </twig:Questionnaire:Choices>
        <twig:Questionnaire:Error />
    </twig:Questionnaire:Item>

    <twig:Questionnaire:Actions>
        <twig:Questionnaire:Previous />
        <twig:Questionnaire:Next />
        <twig:Questionnaire:Submit>Start work</twig:Questionnaire:Submit>
    </twig:Questionnaire:Actions>
</twig:Questionnaire>
```

### Card

Compose `Questionnaire` with `Card` slots while keeping the question title and description semantic.

```twig {"preview":true,"height":"560px"}
<twig:Questionnaire id="card" defaultItem="task" shortcuts="numbers" class="mx-auto max-w-md">
    <twig:Card>
        <twig:Questionnaire:Item name="task" required>
            <twig:Card:Header>
                <twig:Questionnaire:Title>What should the agent work on?</twig:Questionnaire:Title>
                <twig:Questionnaire:Description>Choose the task that should be handled next.</twig:Questionnaire:Description>
                <twig:Card:Action>
                    <twig:Questionnaire:Progress />
                </twig:Card:Action>
            </twig:Card:Header>
            <twig:Card:Content>
                <twig:Questionnaire:Choices>
                    <twig:Questionnaire:Choice value="fix">Fix the failing tests</twig:Questionnaire:Choice>
                    <twig:Questionnaire:Choice value="refactor">Refactor the data layer</twig:Questionnaire:Choice>
                    <twig:Questionnaire:Choice value="docs">Update the integration guide</twig:Questionnaire:Choice>
                </twig:Questionnaire:Choices>
                <twig:Questionnaire:Error />
            </twig:Card:Content>
        </twig:Questionnaire:Item>

        <twig:Questionnaire:Item name="output" required>
            <twig:Card:Header>
                <twig:Questionnaire:Title>What should the final handoff include?</twig:Questionnaire:Title>
                <twig:Questionnaire:Description>Pick the level of detail needed for review.</twig:Questionnaire:Description>
                <twig:Card:Action>
                    <twig:Questionnaire:Progress />
                </twig:Card:Action>
            </twig:Card:Header>
            <twig:Card:Content>
                <twig:Questionnaire:Choices>
                    <twig:Questionnaire:Choice value="summary">Summary only</twig:Questionnaire:Choice>
                    <twig:Questionnaire:Choice value="files">Summary and changed files</twig:Questionnaire:Choice>
                    <twig:Questionnaire:Choice value="review">Full review handoff</twig:Questionnaire:Choice>
                </twig:Questionnaire:Choices>
                <twig:Questionnaire:Error />
            </twig:Card:Content>
        </twig:Questionnaire:Item>

        <twig:Card:Footer>
            <twig:Questionnaire:Actions class="w-full">
                <twig:Questionnaire:Previous />
                <twig:Questionnaire:Next />
                <twig:Questionnaire:Submit>Create task</twig:Questionnaire:Submit>
            </twig:Questionnaire:Actions>
        </twig:Card:Footer>
    </twig:Card>
</twig:Questionnaire>
```

### Dialog

Compose `Questionnaire` inside a `Dialog` while keeping cancellation and dismissal owned by the dialog.

```twig {"preview":true,"height":"320px"}
<twig:Dialog id="questionnaire">
    <twig:Dialog:Trigger>
        <twig:Button variant="outline" {{ ...dialog_trigger_attrs }}>Open clarification</twig:Button>
    </twig:Dialog:Trigger>
    <twig:Dialog:Content>
        <twig:Questionnaire id="dialog" defaultItem="scope">
            <twig:Questionnaire:Item name="scope" required>
                <twig:Dialog:Header>
                    <twig:Questionnaire:Progress />
                    <twig:Questionnaire:Title>How much should the agent change?</twig:Questionnaire:Title>
                    <twig:Questionnaire:Description>Answer before the agent continues.</twig:Questionnaire:Description>
                </twig:Dialog:Header>
                <twig:Questionnaire:Choices>
                    <twig:Questionnaire:Choice value="component">One component</twig:Questionnaire:Choice>
                    <twig:Questionnaire:Choice value="feature">One feature</twig:Questionnaire:Choice>
                    <twig:Questionnaire:Choice value="workspace">The whole workspace</twig:Questionnaire:Choice>
                </twig:Questionnaire:Choices>
                <twig:Questionnaire:Error />
            </twig:Questionnaire:Item>

            <twig:Questionnaire:Item name="tests" required>
                <twig:Dialog:Header>
                    <twig:Questionnaire:Progress />
                    <twig:Questionnaire:Title>Which tests should run afterwards?</twig:Questionnaire:Title>
                    <twig:Questionnaire:Description>The dialog keeps owning dismissal.</twig:Questionnaire:Description>
                </twig:Dialog:Header>
                <twig:Questionnaire:Choices>
                    <twig:Questionnaire:Choice value="targeted">Targeted tests</twig:Questionnaire:Choice>
                    <twig:Questionnaire:Choice value="package">Package suite</twig:Questionnaire:Choice>
                </twig:Questionnaire:Choices>
                <twig:Questionnaire:Error />
            </twig:Questionnaire:Item>

            <twig:Questionnaire:Actions>
                <twig:Questionnaire:Previous />
                <twig:Questionnaire:Next />
                <twig:Questionnaire:Submit>Continue</twig:Questionnaire:Submit>
            </twig:Questionnaire:Actions>
        </twig:Questionnaire>
    </twig:Dialog:Content>
</twig:Dialog>
```

### RTL

To enable RTL support, set the `dir="rtl"` attribute on the root element.

```twig {"preview":true,"height":"480px"}
<div class="mx-auto flex w-full max-w-md flex-col gap-8">
    <twig:Questionnaire id="rtl-ar" dir="rtl" defaultItem="ar-scope" shortcuts="numbers">
        <twig:Questionnaire:Item name="ar-scope" required>
            <twig:Questionnaire:Title>ما الذي يجب أن يعمل عليه الوكيل؟</twig:Questionnaire:Title>
            <twig:Questionnaire:Description>اختر المهمة التالية.</twig:Questionnaire:Description>
            <twig:Questionnaire:Choices>
                <twig:Questionnaire:Choice value="fix">إصلاح الاختبارات الفاشلة</twig:Questionnaire:Choice>
                <twig:Questionnaire:Choice value="refactor">إعادة هيكلة طبقة البيانات</twig:Questionnaire:Choice>
                <twig:Questionnaire:Choice value="docs">تحديث دليل التكامل</twig:Questionnaire:Choice>
            </twig:Questionnaire:Choices>
            <twig:Questionnaire:Error />
        </twig:Questionnaire:Item>

        <twig:Questionnaire:Actions>
            <twig:Questionnaire:Submit>تأكيد</twig:Questionnaire:Submit>
        </twig:Questionnaire:Actions>
    </twig:Questionnaire>

    <twig:Questionnaire id="rtl-he" dir="rtl" defaultItem="he-scope" shortcuts="numbers">
        <twig:Questionnaire:Item name="he-scope" required>
            <twig:Questionnaire:Title>על מה הסוכן צריך לעבוד?</twig:Questionnaire:Title>
            <twig:Questionnaire:Description>בחר את המשימה הבאה.</twig:Questionnaire:Description>
            <twig:Questionnaire:Choices>
                <twig:Questionnaire:Choice value="fix">תיקון הבדיקות שנכשלו</twig:Questionnaire:Choice>
                <twig:Questionnaire:Choice value="refactor">שכתוב שכבת הנתונים</twig:Questionnaire:Choice>
                <twig:Questionnaire:Choice value="docs">עדכון מדריך האינטגרציה</twig:Questionnaire:Choice>
            </twig:Questionnaire:Choices>
            <twig:Questionnaire:Error />
        </twig:Questionnaire:Item>

        <twig:Questionnaire:Actions>
            <twig:Questionnaire:Submit>אישור</twig:Questionnaire:Submit>
        </twig:Questionnaire:Actions>
    </twig:Questionnaire>
</div>
```

## API Reference

::: api-reference
