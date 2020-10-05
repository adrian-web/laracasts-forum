<div>
    <article>
        <div class="flex items-center">
            <h4 class="flex-1 mt-6 text-gray-500">
                <a href="{{ '/profiles/' . $thread->creator->name }}">
                    {{ $thread->creator->name }}
                </a>
                {{ ' created ' . $thread->created_at->diffForHumans()  }}
            </h4>

            @can('update', $thread)
            <div class="mt-6">
                <x-jet-danger-button wire:click="$toggle('editState')">Edit</x-jet-danger-button>
            </div>
            @endcan

            @can('delete', $thread)
            <div class="ml-6 mt-6">
                <x-jet-button type="button" wire:click="$toggle('confirmingThreadDeletion')">
                    {{ __('Delete') }}
                </x-jet-button>
            </div>
            @endcan
        </div>
        <div class="mt-6 text-gray-500" x-data="{ edit: {{ (int) $editState }} }" x-cloak>
            <div x-show="!edit">
                <p>{{ 'Title: ' . $thread->title }}</p>
                <p class="mt-3">{{ $thread->body }}</p>
            </div>

            <div x-show="edit">
                <form wire:submit.prevent="update">
                    <x-jet-input type="text" class="mt-6 block w-full" wire:model.defer="title" required />
                    <x-jet-input-error for="title" class="mt-2" />

                    <textarea class="form-textarea rounded-md shadow-sm mt-3 mb-2 block w-full" wire:model.defer="body"
                        required></textarea>
                    <x-jet-button>Update</x-jet-button>
                    <x-jet-danger-button class="ml-3" wire:click="return">Cancel</x-jet-danger-button>
                    <x-jet-input-error for="body" class="mt-2" />
                </form>
            </div>
        </div>
    </article>

    <x-jet-confirmation-modal wire:model="confirmingThreadDeletion">
        <x-slot name="title">
            {{ __('Delete Thread') }}
        </x-slot>

        <x-slot name="content">
            {{ __('Are you sure you would like to delete this thread?') }}
        </x-slot>

        <x-slot name="footer">
            <x-jet-secondary-button wire:click="$toggle('confirmingThreadDeletion')" wire:loading.attr="disabled">
                {{ __('Nevermind') }}
            </x-jet-secondary-button>

            <x-jet-danger-button class="ml-2" wire:click="delete" wire:loading.attr="disabled">
                {{ __('Delete') }}
            </x-jet-danger-button>
        </x-slot>
    </x-jet-confirmation-modal>
</div>