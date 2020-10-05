<div>
    @foreach ($replies as $reply)

    @livewire('manage-reply', ['reply' => $reply], key($reply->id))

    @endforeach

    {{ $replies->links() }}
</div>