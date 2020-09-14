<x-guest-layout>
    <div class="mb-3">
        <a href="/threads">Threads</a>
    </div>

    <div>

        <article class="mb-3">
            <h4> <a href="#">{{ $thread->owner->name }}</a> {{ ' created ' . $thread->title }}</h4>
            <div class="body">{{ $thread->body }}</div>
        </article>


        <h3 class="mb-3">
            {{ __('Replies') }}
        </h3>

        <div>
            @foreach ($thread->replies as $reply)
            <h4> <a href="#">{{ $reply->owner->name }}</a>
                {{ ' replied ' . $reply->created_at->diffForHumans() }}</h4>
            <div class="body">{{ $reply->body }}</div>
            <hr>
            @endforeach
        </div>

        @if (auth()->check())

        <form action="{{ $thread->path() . '/replies' }}" method="POST">
            @csrf
            <div>
                <label for="body">Body:</label>
                <textarea name="body" id="body" cols="30" rows="10"></textarea>
                <button type="submit" class="button">Post</button>
            </div>
        </form>
        @else
        <a href="{{ route('login') }}">Please sign in</a>

        @endif

    </div>

</x-guest-layout>