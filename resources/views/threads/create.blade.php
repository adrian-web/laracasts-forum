<x-app-layout>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            <a href="/threads" class="mr-5">{{ __('Threads') }}</a>
            <a href="/threads/create" class="mr-5">{{ __('Create') }}</a>
        </h2>
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

                    <div class="mt-5 md:mt-0 md:col-span-2">
                        <div class="shadow overflow-hidden sm:rounded-md">
                            <div class="px-4 py-5 bg-white sm:p-6">
                                <div class="grid grid-cols-6 gap-6">
                                    <div class="col-span-6 sm:col-span-4">
                                        <x-jet-label for="title" value="{{ __('Title') }}" />
                                        <x-jet-input type="text" id="title" name="title" class="mt-1 block w-full" />
                                        <x-jet-input-error for="title" class="mt-2" />
                                    </div>

                                    <div class="col-span-6 sm:col-span-4">
                                        <x-jet-label for="body" value="{{ __('Body') }}" />
                                        <textarea name="body" id="body" rows="10"
                                            class="form-input rounded-md shadow-sm mt-1 block w-full"></textarea>
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
                {{-- @else
                    <a href="{{ route('login') }}">Please sign in</a> --}}

                @endif

            </div>
        </div>
    </div>

</x-app-layout>