<div>
    @foreach ($replies as $reply)

    @livewire('manage-reply', ['reply' => $reply], key($reply->id))

    @endforeach

    <div class="mt-3"></div>

    {{ $replies->links() }}
</div>