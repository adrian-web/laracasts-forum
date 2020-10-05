<div x-data="{ shown: {{ (int) $shown }} }" x-show.transition.opacity.duration.300ms="shown" wire:click="hide"
    style="display: none;"
    class="fixed right-5 bottom-5 cursor-pointer
    px-4 py-2 bg-{{ $color }}-500 border border-transparent rounded-md font-semibold text-xs text-white tracking-widest hover:bg-{{ $color }}-400 active:bg-{{ $color }}-600 focus:outline-none focus:border-{{ $color }}-700 focus:shadow-outline-{{ $color }}">
    {{ $message }}
</div>