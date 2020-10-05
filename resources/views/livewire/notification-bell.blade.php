<div class="mr-3">
    <x-jet-dropdown align="right" width="80" class="">
        <x-slot name="trigger">
            <button type="button" class="mr-5">
                <span class="fa fa-bell-o"></span>
            </button>
        </x-slot>

        <x-slot name="content">

            @forelse ($notifications as $notification)
            <x-jet-dropdown-link href="{{ $notification->data['link'] }}"
                wire:click.prevent="confirm({{$notification}})">
                {{ $notification->data['message'] }}
            </x-jet-dropdown-link>

            @if ( $loop->last )
            @else
            <div class="border-t border-gray-100"></div>
            @endif

            @empty
            <p
                class="block px-4 py-2 text-sm leading-5 text-gray-700 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 transition duration-150 ease-in-out">
                There's no unread notifications...
            </p>

            @endforelse

        </x-slot>
    </x-jet-dropdown>

</div>