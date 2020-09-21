<div class="flex">
    <x-jet-nav-link href="/threads" :active=false class="mr-5">
        {{ __('Threads') }}
    </x-jet-nav-link>
    <x-jet-dropdown align="top" width="48" class="">
        <x-slot name="trigger">
            <x-jet-nav-link href="#" :active=false class="mr-5">
                {{ __('Channels') }}
            </x-jet-nav-link>
        </x-slot>

        <x-slot name="content">

            @foreach ($channels as $channel)
            <x-jet-dropdown-link href="/threads/{{$channel->slug}}">
                {{ $channel->name }}
            </x-jet-dropdown-link>
            <div class="border-t border-gray-100"></div>
            @endforeach

        </x-slot>
    </x-jet-dropdown>
    <x-jet-nav-link href="/threads/create" :active=false class="mr-5">
        {{ __('Create') }}
    </x-jet-nav-link>
</div>