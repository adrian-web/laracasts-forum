<div>
    <p class="text-gray-500">This thread was published {{ $thread->created_at->diffForHumans() }} by <a
            href="{{ $thread->creator->path() }}">{{ $thread->creator->name }}</a>,
        and currently has {{ $thread->replies_count }}
        {{ Str::plural('comment', $thread->replies_count) }}.</p>
    @auth
    <x-state-button class="mt-3" :state="$subscribedState" id="subscribe1" wire:click="subscribe">
        {{ __('Subscribe') }}
    </x-state-button>
    @endauth
</div>