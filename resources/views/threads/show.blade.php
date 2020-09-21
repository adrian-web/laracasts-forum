<x-app-layout>

    <x-slot name="header">
        <x-forum-header />
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-6 sm:px-20 bg-white border-b border-gray-200">

                    <article>
                        <h4 class="mt-6 text-gray-500">
                            <a href="#">{{ $thread->owner->name }}</a> {{ ' created ' . $thread->title }}
                        </h4>
                        <div class="mt-6 text-gray-500">{{ $thread->body }}</div>
                    </article>

                    <h3 class="mt-8 text-2xl">
                        {{ __('Replies') }}
                    </h3>

                    <div class="mt-6">
                        @foreach ($thread->replies as $reply)
                        <h4 class="mt-6 text-gray-500">
                            <a href="#">{{ $reply->owner->name }}</a>
                            {{ ' replied ' . $reply->created_at->diffForHumans() }}
                        </h4>
                        <div class="mt-6 text-gray-500">{{ $reply->body }}</div>
                        <div class="mt-6"></div>
                        @if ( $loop->last )
                        @else
                        <hr>
                        @endif
                        @endforeach
                    </div>

                    @if (auth()->check())

                    <form action="{{ $thread->path() . '/replies' }}" method="POST">
                        @csrf

                        <div class="mt-5 md:mt-0 md:col-span-2">
                            <div class="shadow overflow-hidden sm:rounded-md">
                                <div class="px-4 py-5 bg-white sm:p-6">
                                    <div class="grid grid-cols-6 gap-6">

                                        <div class="col-span-6 sm:col-span-4">
                                            <x-jet-label for="body" value="{{ __('Body') }}" />
                                            <textarea name="body" id="body" rows="10"
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
                        <a href="{{ route('login') }}">Please sign in</a>
                    </h4>
                    @endif
                </div>
            </div>
        </div>
    </div>

</x-app-layout>