<div>
    <div class="flex items-center mt-6">
        <h4 class="flex-1 text-gray-500">
            <a href="{{ '/profiles/' . $reply->owner->name }}">{{ $reply->owner->name }}</a>
            {{ ' replied ' . $reply->created_at->diffForHumans() }}
        </h4>

        <form wire:submit.prevent="favorite">
            <x-jet-button class="{{ $favoriteState ? 'text-red-600' : '' }}" id="{{'favorite' . $reply->id}}">
                <div class="">
                    <span class="fa fa-heart-o" aria-hidden="true"></span>
                    <span class="ml-1">{{ $reply->favorites_count }}</span>
                </div>
            </x-jet-button>
        </form>

        @can('update', $reply)
        <div class="ml-6">
            <x-jet-danger-button wire:click="$toggle('editState')">Edit</x-jet-danger-button>
        </div>
        @endcan

        @can('delete', $reply)
        <form wire:submit.prevent="delete">
            <div class="ml-6">
                <x-jet-button>
                    {{ __('Delete') }}
                </x-jet-button>
            </div>
        </form>
        @endcan
    </div>

    <div class="mt-6" x-data="{ edit: {{ (int) $editState }} }" x-cloak>
        <div class="text-gray-500" x-show="!edit">{{ $reply->body }}</div>

        <div x-show="edit">
            <form wire:submit.prevent="update">
                <textarea class="form-textarea rounded-md shadow-sm mb-2 block w-full" wire:model.defer="reply.body"
                    required></textarea>
                <x-jet-button>Update</x-jet-button>
                <x-jet-danger-button class="ml-3" wire:click="return">Cancel</x-jet-danger-button>
            </form>
        </div>
    </div>
</div>

@guest
<script>
    document.getElementById("{{'favorite' . $reply->id}}").disabled = true; 
</script>
@endguest