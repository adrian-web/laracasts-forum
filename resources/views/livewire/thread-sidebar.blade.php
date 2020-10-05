<div>
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