@php
$body = $reply->displayMentionedUsers();
@endphp

<div id={{'reply' . $reply->id}} class="">
    <div class="flex flex-col sm:flex-row sm:items-center mt-5 ">
        <div class=" flex-1 items-center inline-flex">
            <img class="h-8 w-8 rounded-full object-cover" src="{{ $reply->owner->profile_photo_url }}"
                alt="{{ $reply->owner->username }}" />
            <h4 class="ml-3 text-gray-500">
                <a href="{{ $reply->owner->path() }}">{{ $reply->owner->name }}</a>
                {{ ' replied ' . $reply->created_at->diffForHumans() }}
            </h4>
        </div>

        <div class="inline-flex items-center mt-3 sm:mt-0">
            @can('update', $reply)
            <x-jet-secondary-button id="{{'markAsBest' . $reply->id}}" wire:click="best">
                <span class="fa fa-star" aria-hidden="true"></span>
            </x-jet-secondary-button>
            @endcan

            <x-state-button class="ml-4" :state="$favoriteState" id="{{'favorite' . $reply->id}}" wire:click="favorite">
                <span class="fa fa-heart" aria-hidden="true"></span>
                <span class="ml-1 leading-3">{{ $favoriteCount }}</span>
            </x-state-button>

            @can('update', $reply)
            <div class="ml-4">
                <x-jet-secondary-button wire:click="$toggle('editState')">
                    <span class="fa fa-chevron-down" aria-hidden="true"></span>
                </x-jet-secondary-button>
            </div>
            @endcan

            @can('delete', $reply)
            <div class="ml-4" x-data="{ destroy: @entangle('deleteState'), destroying: false }" x-cloak>
                <div x-show="!destroy">
                    <x-jet-danger-button wire:click="$toggle('deleteState')">
                        <span class="fa fa-trash-o" aria-hidden="true"></span>
                    </x-jet-danger-button>
                </div>
                <div x-show="destroy">
                    <div x-show="!destroying">
                        <x-jet-danger-button wire:click="delete" x-on:click="destroying = true"
                            x-on:click.away="destroy = false">
                            <span class="fa fa-check" aria-hidden="true"></span>
                        </x-jet-danger-button>
                    </div>
                    <div x-show="destroying">
                        <x-jet-danger-button>
                            <svg class="animate-spin h-3 w-3 text-white" xmlns="http://www.w3.org/2000/svg" fill="none"
                                viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                                    stroke-width="4">
                                </circle>
                                <path class="opacity-75" fill="currentColor"
                                    d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                                </path>
                            </svg>
                        </x-jet-danger-button>
                    </div>
                </div>
            </div>
            @endcan
        </div>
    </div>

    <div class="mt-6 text-gray-500" x-data="{ edit: {{ (int) $editState }} }" x-cloak>
        <div class="" x-show="!edit">{!! $body !!}</div>

        <div x-show="edit">
            <form wire:submit.prevent="update">
                <textarea class="form-textarea rounded-md shadow-sm mb-2 block w-full" wire:model.defer="body"
                    required></textarea>
                <x-jet-input-error for="body" class="mt-2" />
                <div class="flex items-center">
                    <x-jet-button>
                        <span wire:loading wire:target="update">
                            <svg class="animate-spin -ml-1 mr-3 h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg"
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
    document.getElementById("{{'favorite' . $reply->id}}").classList.add("cursor-not-allowed", "disabled:opacity-100");
</script>
@endguest

@can('update', $reply)
@if ($reply->thread->best_reply_id !== null)
@php
$best = $reply->thread->best_reply_id;
@endphp

@if ($best == $reply->id)
<script>
    document.getElementById("{{'reply' . $best}}").classList.add("bg-green-200", "rounded-md", "shadow-nd", "p-2");
</script>
@endif

@endif
@endcan