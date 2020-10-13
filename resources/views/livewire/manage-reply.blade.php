@php
$body = $reply->displayMentionedUsers();
@endphp

@if ($reply->thread->best_reply_id !== null && $reply->isBest)

@php
$classes = "bg-green-200 rounded-md shadow-md p-2";
@endphp

@endif

<div>
    <div id={{'reply' . $reply->id}} class="my-2 {{$classes}}" x-data="{...judging(), ...changing()}" x-show="!killed">
        <div class="flex flex-col sm:flex-row sm:items-center ">
            <div class=" flex-1 items-center inline-flex">
                <img class="h-8 w-8 rounded-full object-cover" src="{{ $reply->owner->profile_photo_url }}"
                    alt="{{ $reply->owner->username }}" />
                <h4 class="ml-2 text-sm text-gray-500">
                    <a href="{{ $reply->owner->path() }}">
                        {{ $reply->owner->name }}
                    </a>
                    {{ ' replied ' . $reply->created_at->diffForHumans() }}
                </h4>
            </div>

            @if (! $reply->thread->locked)
            <div class="inline-flex items-center mt-2 sm:mt-0">
                <x-state-button :state="$favoriteState" wire:click="favorite">
                    <span class="fa fa-heart" aria-hidden="true"></span>
                    <span class="ml-1 leading-3">{{ $favoriteCount }}</span>
                </x-state-button>

                @can('update', $reply->thread)
                <x-jet-secondary-button class="ml-3" wire:click="best">
                    <span class="fa fa-star" aria-hidden="true"></span>
                </x-jet-secondary-button>
                @endcan

                @can('update', $reply)
                <x-jet-secondary-button class="ml-3" x-on:click="show = !show" x-cloak>
                    <span class="fa fa-chevron-down" aria-hidden="true" x-show="isClose()"></span>
                    <span class="fa fa-chevron-up" aria-hidden="true" x-show="isOpen()"></span>
                </x-jet-secondary-button>
                @endcan
            </div>
            @endif
        </div>

        <div class="mt-4 text-gray-500" x-cloak>
            <div x-show="isClose()">{!! $body !!}</div>

            <div x-show="isOpen()">
                <form wire:submit.prevent="update">
                    <textarea class="form-textarea rounded-md shadow-sm mb-2 block w-full" wire:model.defer="body"
                        required></textarea>
                    <x-jet-input-error for="body" class="mt-2" />
                    <div class="flex items-center">
                        <x-jet-button x-on:click="close">
                            {{ __('Update') }}
                        </x-jet-button>
                        <x-jet-secondary-button class="ml-3" x-on:click="close" wire:click="return">
                            {{ __('Cancel') }}
                        </x-jet-secondary-button>
                        @can('delete', $reply)
                        <div class="ml-auto" x-cloak>
                            <div x-show="isAlive()">
                                <x-jet-danger-button x-on:click="judge">
                                    <span class="fa fa-trash-o" aria-hidden="true"></span>
                                </x-jet-danger-button>
                            </div>
                            <div x-show="isDying()">
                                <x-jet-danger-button x-on:click="kill" x-on:click.away="spare" wire:click="delete">
                                    <span class="fa fa-check" aria-hidden="true"></span>
                                </x-jet-danger-button>
                            </div>
                        </div>
                        @endcan
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>