@php
$body = $reply->displayMentionedUsers();
@endphp

<div>
    <div class="flex items-center mt-6">
        <h4 class="flex-1 text-gray-500">
            <a href="{{ $reply->owner->path() }}">{{ $reply->owner->name }}</a>
            {{ ' replied ' . $reply->created_at->diffForHumans() }}
        </h4>

        <form wire:submit.prevent="favorite">
            <x-state-button :state="$favoriteState" id="{{'favorite' . $reply->id}}">
                <span wire:loading wire:target="favorite">
                    <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg"
                        fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4">
                        </circle>
                        <path class="opacity-75" fill="currentColor"
                            d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                        </path>
                    </svg>
                </span>
                <span class="fa fa-heart-o" aria-hidden="true"></span>
                <span class="ml-1">{{ $favoriteCount }}</span>
            </x-state-button>
        </form>

        @can('update', $reply)
        <div class="ml-6">
            <x-jet-secondary-button wire:click="$toggle('editState')">Edit</x-jet-secondary-button>
        </div>
        @endcan

        @can('delete', $reply)
        <form wire:submit.prevent="delete">
            <div class="ml-6" x-data="{ destroy: @entangle('deleteState'), destroying: false }" x-cloak>
                <div x-show="!destroy">
                    <x-jet-danger-button wire:click="$toggle('deleteState')">
                        {{ __('Delete') }}
                    </x-jet-danger-button>
                </div>
                <div x-show="destroy">
                    <div x-show="!destroying">
                        <x-jet-danger-button type="submit" x-on:click="destroying = true"
                            x-on:click.away="destroy = false">
                            {{ __('Confirm') }}
                        </x-jet-danger-button>
                    </div>
                    <div x-show="destroying">
                        <x-jet-danger-button>
                            <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg"
                                fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                                    stroke-width="4">
                                </circle>
                                <path class="opacity-75" fill="currentColor"
                                    d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                                </path>
                            </svg>
                            {{ __('Deleting') }}
                        </x-jet-danger-button>
                    </div>
                </div>
            </div>
        </form>
        @endcan
    </div>

    <div class="mt-6" x-data="{ edit: {{ (int) $editState }} }" x-cloak>
        <div class="text-gray-500" x-show="!edit">{!! $body !!}</div>

        <div x-show="edit">
            <form wire:submit.prevent="update">
                <textarea class="form-textarea rounded-md shadow-sm mb-2 block w-full" wire:model.defer="body"
                    required></textarea>
                <x-jet-input-error for="body" class="mt-2" />
                <div class="flex items-center">
                    <x-jet-button>
                        <span wire:loading wire:target="update">
                            <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg"
                                fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                                    stroke-width="4">
                                </circle>
                                <path class="opacity-75" fill="currentColor"
                                    d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                                </path>
                            </svg>
                        </span>
                        {{ __('Update') }}
                    </x-jet-button>
                    <x-jet-secondary-button class="ml-3" wire:click="return">Cancel</x-jet-secondary-button>
                </div>
            </form>
        </div>
    </div>
</div>

@guest
<script>
    document.getElementById("{{'favorite' . $reply->id}}").disabled = true; 
</script>
@endguest