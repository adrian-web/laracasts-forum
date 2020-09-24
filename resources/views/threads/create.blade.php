<x-app-layout>

    <x-slot name="header">
        <x-forum-header />
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">

                <h3 class="mt-8 ml-6 text-2xl">
                    {{ __('Create a thread') }}
                </h3>

                @if (auth()->check())

                <form action="/threads" method="POST">
                    @csrf

                    <div class="lg:mt-5 md:mt-0 md:col-span-2">
                        <div class="shadow overflow-hidden sm:rounded-md">
                            <div class="px-4 py-5 bg-white sm:p-6">
                                <div class="grid grid-cols-6 gap-6">
                                    <div class="col-span-6 sm:col-span-4">
                                        <x-jet-label for="channel_id" value="{{ __('Choose a channel') }}" />
                                        <select name="channel_id" id="channel_id"
                                            class="form-select rounded-md shadow-sm mt-1 block w-full" required>
                                            <option value="">Choose a channel...</option>
                                            @foreach ($channels as $channel)
                                            <option value="{{ $channel->id }}"
                                                {{ old('channel_id') == $channel->id ? 'selected' : ''}}>
                                                {{ $channel->slug }}</option>
                                            @endforeach
                                        </select>
                                        <x-jet-input-error for="channel_id" class="mt-2" />
                                    </div>

                                    <div class="col-span-6 sm:col-span-4">
                                        <x-jet-label for="title" value="{{ __('Title') }}" />
                                        <x-jet-input type="text" id="title" name="title" class="mt-1 block w-full"
                                            value="{{ old('title') }}" required />
                                        <x-jet-input-error for="title" class="mt-2" />
                                    </div>

                                    <div class="col-span-6 sm:col-span-4">
                                        <x-jet-label for="body" value="{{ __('Body') }}" />
                                        <textarea name="body" id="body" rows="10"
                                            class="form-textarea rounded-md shadow-sm mt-1 block w-full"
                                            required>{{ old('body') }}</textarea>
                                        <x-jet-input-error for="body" class="mt-2" />

                                    </div>
                                </div>
                            </div>

                            <div class="flex items-center justify-end px-4 py-3 bg-gray-50 text-right sm:px-6">
                                <x-jet-button>
                                    {{ __('Publish') }}
                                </x-jet-button>
                            </div>
                        </div>
                    </div>

                </form>

                @endif

            </div>
        </div>
    </div>

</x-app-layout>