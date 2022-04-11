<div>
    {{-- Action bar --}}
    <div class="flex items-center gap-4 mb-6">
        <div class="relative flex-1 max-w-sm">
            <input wire:model.debounce.300ms="search" type="search" placeholder="Search contacts..."
                   class="input pl-9" />
            <svg class="absolute left-3 top-2.5 w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
            </svg>
        </div>
        <select wire:model="perPage" class="input w-auto">
            <option value="5">5 / page</option>
            <option value="10">10 / page</option>
            <option value="25">25 / page</option>
        </select>
        <button wire:click="openCreate" class="btn-primary ml-auto">
            + New Contact
        </button>
    </div>

    {{-- Table --}}
    <div class="card overflow-hidden">
        <table class="w-full text-sm">
            <thead class="bg-gray-50 dark:bg-gray-700 text-gray-500 dark:text-gray-400 uppercase text-xs">
                <tr>
                    <th class="px-6 py-3 text-left">
                        <button wire:click="sortBy('name')" class="flex items-center gap-1 hover:text-gray-700 dark:hover:text-gray-200">
                            Name <span class="{{ $sortField === 'name' ? 'text-brand-500' : 'opacity-30' }}">{{ $sortField === 'name' ? ($sortDirection === 'asc' ? '↑' : '↓') : '↕' }}</span>
                        </button>
                    </th>
                    <th class="px-6 py-3 text-left">
                        <button wire:click="sortBy('email')" class="flex items-center gap-1 hover:text-gray-700 dark:hover:text-gray-200">
                            Email <span class="{{ $sortField === 'email' ? 'text-brand-500' : 'opacity-30' }}">{{ $sortField === 'email' ? ($sortDirection === 'asc' ? '↑' : '↓') : '↕' }}</span>
                        </button>
                    </th>
                    <th class="px-6 py-3 text-left">Company</th>
                    <th class="px-6 py-3 text-right">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
                @forelse($contacts as $contact)
                    <tr wire:key="{{ $contact->id }}" class="hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors">
                        <td class="px-6 py-4 font-medium">{{ $contact->name }}</td>
                        <td class="px-6 py-4 text-gray-500 dark:text-gray-400">{{ $contact->email }}</td>
                        <td class="px-6 py-4 text-gray-500 dark:text-gray-400">{{ $contact->company ?? '—' }}</td>
                        <td class="px-6 py-4 text-right space-x-3">
                            <button wire:click="openEdit({{ $contact->id }})"
                                class="text-xs font-medium text-brand-600 hover:text-brand-800 dark:text-brand-400">Edit</button>
                            <button wire:click="confirmDelete({{ $contact->id }})"
                                class="text-xs font-medium text-red-500 hover:text-red-700">Delete</button>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="px-6 py-16 text-center text-gray-400">
                            @if($search)
                                No contacts match "{{ $search }}"
                            @else
                                No contacts yet. <button wire:click="openCreate" class="text-brand-600 hover:underline">Add one</button>.
                            @endif
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
        @if($contacts->hasPages())
            <div class="px-6 py-4 border-t border-gray-100 dark:border-gray-700">
                {{ $contacts->links() }}
            </div>
        @endif
    </div>

    {{-- Create/Edit Modal — Alpine animates, Livewire controls state --}}
    @if($showModal)
    <div x-data x-init="$el.querySelector('[autofocus]')?.focus()"
         @keydown.escape.window="$wire.set('showModal', false)"
         class="fixed inset-0 z-50 flex items-center justify-center bg-black/50">
        <div class="card w-full max-w-md p-6" @click.stop>
            <h2 class="text-lg font-bold mb-5">{{ $editingId ? 'Edit Contact' : 'New Contact' }}</h2>
            <form wire:submit.prevent="save" class="space-y-4">
                <div>
                    <label class="block text-sm font-medium mb-1">Name *</label>
                    <input wire:model.lazy="name" type="text" class="input" autofocus />
                    @error('name') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label class="block text-sm font-medium mb-1">Email *</label>
                    <input wire:model.lazy="email" type="email" class="input" />
                    @error('email') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium mb-1">Phone</label>
                        <input wire:model.lazy="phone" type="tel" class="input" />
                    </div>
                    <div>
                        <label class="block text-sm font-medium mb-1">Company</label>
                        <input wire:model.lazy="company" type="text" class="input" />
                    </div>
                </div>
                <div class="flex justify-end gap-3 pt-2">
                    <button type="button" wire:click="$set('showModal', false)" class="btn-secondary">Cancel</button>
                    <button type="submit" class="btn-primary">
                        <span wire:loading wire:target="save">
                            <svg class="animate-spin h-3 w-3" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.4 0 0 5.4 0 12h4z"></path>
                            </svg>
                        </span>
                        {{ $editingId ? 'Update' : 'Create' }}
                    </button>
                </div>
            </form>
        </div>
    </div>
    @endif

    {{-- Delete confirmation --}}
    @if($showDeleteConfirm)
    <div @keydown.escape.window="$wire.set('showDeleteConfirm', false)"
         class="fixed inset-0 z-50 flex items-center justify-center bg-black/50">
        <div class="card w-full max-w-sm p-6 text-center" @click.stop>
            <div class="w-12 h-12 bg-red-100 rounded-full flex items-center justify-center mx-auto mb-4">
                <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                </svg>
            </div>
            <h3 class="font-bold text-lg mb-2">Delete Contact?</h3>
            <p class="text-sm text-gray-500 mb-6">This cannot be undone.</p>
            <div class="flex justify-center gap-3">
                <button wire:click="$set('showDeleteConfirm', false)" class="btn-secondary">Cancel</button>
                <button wire:click="delete" class="btn-danger">Delete</button>
            </div>
        </div>
    </div>
    @endif
</div>
