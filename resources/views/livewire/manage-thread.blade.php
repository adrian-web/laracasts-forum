<div class="lg:flex py-12">
    <div class="lg:flex-auto max-w-7xl sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
            <div class="p-6 sm:px-20 bg-white border-b border-gray-200">

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
                                <x-jet-input type="text" class="mt-6 block w-full" wire:model.defer="thread.title"
                                    required />
                                <textarea class="form-textarea rounded-md shadow-sm mt-3 mb-2 block w-full"
                                    wire:model.defer="thread.body" required></textarea>
                                <x-jet-button>Update</x-jet-button>
                                <x-jet-danger-button class="ml-3" wire:click="return">Cancel</x-jet-danger-button>
                            </form>
                        </div>
                    </div>
                </article>

                <h3 class="mt-8 text-2xl">
                    {{ __('Replies') }}
                </h3>

                @foreach ($replies as $reply)

                @livewire('manage-reply', ['reply' => $reply], key($reply->id))

                @endforeach

                {{ $replies->links() }}

                @if (auth()->check())

                <form wire:submit.prevent="createReply">
                    <div class="lg:mt-5 md:mt-0 md:col-span-2">
                        <div class="shadow overflow-hidden sm:rounded-md">
                            <div class="px-4 py-5 bg-white sm:p-6">
                                <div class="grid grid-cols-6 gap-6">

                                    <div class="col-span-6 sm:col-span-4">
                                        <x-jet-label for="bodyReply" value="{{ __('Body') }}" />
                                        <textarea name="bodyReply" id="bodyReply" rows="10" wire:model.defer="bodyReply"
                                            class="form-textarea rounded-md shadow-sm mt-1 block w-full"
                                            required></textarea>
                                        <x-jet-input-error for="bodyReply" class="mt-2" />
                                    </div>

                                </div>
                            </div>

                            <div class="flex items-center justify-end px-4 py-3 bg-gray-50 text-right sm:px-6">
                                <x-jet-button>
                                    {{ __('Post') }}
                                </x-jet-button>
                            </div>
                        </div>
                    </div>

                </form>
                @else
                <h4 class="mt-8 text-2xl">
                    <a href="{{ route('login') }}">Please sign in...</a>
                </h4>
                @endif
            </div>
        </div>
    </div>

    <div class="lg:flex-1 sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
            <div class="p-6 sm:px-20 bg-white border-b border-gray-200">
                <p class="text-gray-500">This thread was published {{ $thread->created_at->diffForHumans() }} by <a
                        href="{{ '/profiles/' . $thread->creator->name }}">{{ $thread->creator->name }}</a>,
                    and currently has {{ $thread->replies_count }}
                    {{ Str::plural('comment', $thread->replies_count) }}.</p>
                @auth
                <form wire:submit.prevent="subscribe">
                    <x-jet-button class="mt-3 {{ $subscribedState ? 'text-red-600' : '' }}">
                        {{ __('Subscribe') }}
                    </x-jet-button>
                </form>
                @endauth
            </div>
        </div>
    </div>

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