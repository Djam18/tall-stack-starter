<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use Livewire\Attributes\Validate;
use Livewire\Attributes\Url;

// Full TALL stack wiring: Livewire (server) + Alpine (client) + Tailwind (style)
// This is the "full demo" component showing all patterns together.
// Shows: search, sort, paginate, create/edit modal, delete confirm, flash.
//
// LIVEWIRE 3 MIGRATION — Jul 2023
// #[Url] attribute: search/sort state synced to URL automatically (new in LW3)
// #[Validate] per property replaces protected $rules
// wire:navigate in the layout for SPA-like navigation (new in LW3)

class ContactManager extends Component
{
    use WithPagination;
    use WithFileUploads;

    // Table state — #[Url] syncs to browser URL query string
    #[Url]
    public string $search = '';
    #[Url]
    public string $sortField = 'name';
    #[Url]
    public string $sortDirection = 'asc';
    public int $perPage = 10;

    // Form state
    public bool $showModal = false;
    public ?int $editingId = null;

    #[Validate('required|string|max:255')]
    public string $name = '';

    #[Validate('required|email|max:255')]
    public string $email = '';

    #[Validate('nullable|string|max:20')]
    public string $phone = '';

    #[Validate('nullable|string|max:255')]
    public string $company = '';

    // Delete state
    public bool $showDeleteConfirm = false;
    public ?int $deletingId = null;

    public function updatingSearch(): void { $this->resetPage(); }

    public function sortBy(string $field): void
    {
        $this->sortField === $field
            ? $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc'
            : ($this->sortField = $field) && ($this->sortDirection = 'asc');
    }

    public function openCreate(): void
    {
        $this->reset(['editingId', 'name', 'email', 'phone', 'company']);
        $this->resetErrorBag();
        $this->showModal = true;
    }

    public function openEdit(int $id): void
    {
        $contact = \App\Models\Contact::findOrFail($id);
        $this->editingId = $contact->id;
        $this->name = $contact->name;
        $this->email = $contact->email;
        $this->phone = $contact->phone ?? '';
        $this->company = $contact->company ?? '';
        $this->resetErrorBag();
        $this->showModal = true;
    }

    public function save(): void
    {
        $validated = $this->validate();

        if ($this->editingId) {
            \App\Models\Contact::findOrFail($this->editingId)->update($validated);
            $this->dispatch('flash', 'Contact updated successfully.', 'success');
        } else {
            \App\Models\Contact::create($validated);
            $this->dispatch('flash', 'Contact created successfully.', 'success');
        }

        $this->showModal = false;
    }

    public function confirmDelete(int $id): void
    {
        $this->deletingId = $id;
        $this->showDeleteConfirm = true;
    }

    public function delete(): void
    {
        if ($this->deletingId) {
            \App\Models\Contact::findOrFail($this->deletingId)->delete();
            $this->dispatch('flash', 'Contact deleted.', 'success');
        }
        $this->showDeleteConfirm = false;
        $this->deletingId = null;
    }

    public function render()
    {
        $contacts = \App\Models\Contact::query()
            ->when($this->search, fn($q) => $q->search($this->search))
            ->orderBy($this->sortField, $this->sortDirection)
            ->paginate($this->perPage);

        return view('livewire.contact-manager', compact('contacts'))
            ->layout('layouts.app', ['header' => 'Contacts']);
    }
}
