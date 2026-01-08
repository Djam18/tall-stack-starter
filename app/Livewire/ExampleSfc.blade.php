<?php

// TALL Stack V4 — Example SFC.
// The definitive TALL boilerplate starter component for Livewire 4.
//
// This file is the recommended starting point for new Livewire components:
//   php artisan make:livewire ExampleSfc --sfc
//
// TALL Stack V4 summary (Jan 2026):
//
//   T — Tailwind 4
//     CSS-first config (@import "tailwindcss" + @theme in CSS)
//     10x faster builds, Lightning CSS engine
//     CSS anchor positioning, print: variant, no config.js
//
//   A — Alpine 3.14
//     x-anchor for popover/tooltip positioning (no floating-ui needed)
//     wire:model and Alpine $wire share the same reactive boundary in LW4
//     @alpinejs/anchor, improved morph, better TypeScript types
//
//   L — Livewire 4
//     Single-File Components (SFC) — PHP + Blade in one file
//     Islands architecture — #[Lazy(isolate: true)]
//     #[Locked] — server-enforced immutable properties
//     wire:stream — server-push streaming (AI, reports)
//     Namespace: app/Livewire/ (not app/Http/Livewire/)
//
//   L — Laravel 12
//     Slim bootstrap (app.php withRouting/withMiddleware/withExceptions)
//     bootstrap/providers.php (replaces config/app.php providers[])
//     /up health route by default
//     PHP 8.3 required
//
// This is the stack I wish had existed when I started in Jan 2022.
// The React dev in me still misses JSX sometimes, but the productivity
// gains from Livewire + Alpine are real. Less JavaScript = fewer bugs.
// -- Abdel, Jan 2026

use Livewire\Component;
use Livewire\Attributes\{Validate, Computed, Url};

new class extends Component {
    #[Url(except: '')]
    public string $query = '';

    #[Validate('required|min:3')]
    public string $message = '';

    public bool $submitted = false;

    #[Computed]
    public function characterCount(): int
    {
        return strlen($this->message);
    }

    public function submit(): void
    {
        $this->validate();
        $this->submitted = true;
        $this->dispatch('notify', message: 'Submitted!', type: 'success');
    }

    public function render()
    {
        return $this->view();
    }
}

?>

<div class="max-w-md mx-auto p-6 card">
    <h1 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">
        TALL Stack V4 — SFC Example
    </h1>

    @if ($submitted)
        <div class="rounded-lg bg-brand-50 border border-brand-200 p-4 text-brand-700 text-sm">
            Submitted! This is a Livewire 4 SFC with TW4 + Alpine 3.14.
        </div>
    @else
        <form wire:submit="submit" class="space-y-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                    Message
                </label>
                <textarea
                    wire:model.live="message"
                    rows="3"
                    class="input"
                    placeholder="Type something..."
                ></textarea>
                @error('message')
                    <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                @enderror
                <p class="mt-1 text-xs text-gray-400">{{ $this->characterCount }} characters</p>
            </div>

            <button type="submit" class="btn-primary w-full">
                <span wire:loading.remove>Submit</span>
                <span wire:loading>Sending...</span>
            </button>
        </form>
    @endif
</div>
