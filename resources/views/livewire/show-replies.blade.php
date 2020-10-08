<div>

    @if ($replies->total())
    <h3 class="mt-5 text-2xl text-gray-500">
        {{ __('Replies') }}
    </h3>

    @foreach ($replies as $reply)

    @livewire('manage-reply', ['reply' => $reply], key($reply->id))

    @endforeach

    <div class="mt-3"></div>

    {{ $replies->links() }}
    @endif

</div>