<div class="lg:flex py-12">
    <div class="lg:flex-auto max-w-7xl sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
            <div class="p-6 sm:px-20 bg-white border-b border-gray-200">

                <article>
                    <div class="flex">
                        <h4 class="flex-1 items-center mt-6 text-gray-500">
                            <a href="{{ '/profiles/' . $thread->creator->name }}">
                                {{ $thread->creator->name }}
                            </a>
                            {{ ' created ' }}
                            <a href="{{ $thread->path() }}">
                                {{ $thread->title }}
                            </a>
                        </h4>

                        @can('delete', $thread)
                        <form wire:submit.prevent="delete">
                            @csrf
                            <div class="mt-6">
                                <x-jet-button>
                                    {{ __('Delete') }}
                                </x-jet-button>
                            </div>
                        </form>
                        @endcan
                    </div>
                    <div class="mt-6 text-gray-500">{{ $thread->body }}</div>
                </article>

                <h3 class="mt-8 text-2xl">
                    {{ __('Replies') }}
                </h3>

                @foreach ($replies as $reply)

                @livewire('manage-reply', ['reply' => $reply], key($reply->id))

                @endforeach

                {{ $replies->links() }}

                @if (auth()->check())

                <form wire:submit.prevent="create">
                    @csrf

                    <div class="lg:mt-5 md:mt-0 md:col-span-2">
                        <div class="shadow overflow-hidden sm:rounded-md">
                            <div class="px-4 py-5 bg-white sm:p-6">
                                <div class="grid grid-cols-6 gap-6">

                                    <div class="col-span-6 sm:col-span-4">
                                        <x-jet-label for="body" value="{{ __('Body') }}" />
                                        <textarea name="body" id="body" rows="10" wire:model.defer="body"
                                            class="form-textarea rounded-md shadow-sm mt-1 block w-full"></textarea>
                                        <x-jet-input-error for="body" class="mt-2" />
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
            </div>
        </div>
    </div>
</div>