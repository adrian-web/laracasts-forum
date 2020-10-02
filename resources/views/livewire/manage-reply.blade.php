<div>
    <div class="flex items-center mt-6">
        <h4 class="flex-1 text-gray-500">
            <a href="{{ '/profiles/' . $reply->owner->name }}">{{ $reply->owner->name }}</a>
            {{ ' replied ' . $reply->created_at->diffForHumans() }}
        </h4>

        <form wire:submit.prevent="favorite">
            <x-jet-button class="{{ $favoriteState ? 'text-red-600' : '' }}">
                <div class="">
                    <span class="fa fa-heart" aria-hidden="true"></span>
                    <span class="ml-1">{{ $reply->favorites_count }}</span>
                </div>
            </x-jet-button>
        </form>

        @can('delete', $reply)
        <form wire:submit.prevent="delete">
            @csrf
            <div class="ml-6">
                <x-jet-button>
                    {{ __('Delete') }}
                </x-jet-button>
            </div>
        </form>
        @endcan

        @can('update', $reply)
        <div class="ml-6">
            <x-jet-danger-button wire:click="$toggle('editState')">Edit</x-jet-danger-button>
        </div>
        @endcan

    </div>

    <div class="mt-6" x-data="{ edit: {{ (int) $editState }} }" x-cloak>
        <div class="text-gray-500" x-show="!edit">{{ $reply->body }}</div>

        <div x-show="edit">
            <form wire:submit.prevent="update">
                @csrf
                <textarea class="form-textarea rounded-md shadow-sm mt-1 mb-1 block w-full"
                    wire:model.defer="reply.body" required></textarea>
                <x-jet-button>Update</x-jet-button>
                <x-jet-danger-button class="ml-3" wire:click="return">Cancel</x-jet-danger-button>
            </form>
        </div>
    </div>
</div>