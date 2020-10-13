<div>

    @if ($replies->total())
    <h3 class="mt-5 text-xl text-gray-500">
        {{ __('Replies') }}
    </h3>

    @foreach ($replies as $reply)

    @livewire('manage-reply', ['reply' => $reply], key($reply->id))

    @endforeach

    {{ $replies->links() }}
    @endif

</div>