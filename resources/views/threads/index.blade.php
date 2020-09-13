<h2>
    {{ __('Threads') }}
</h2>

<div>
    <div>
        @foreach ($threads as $thread)
        <article>
            <a href="{{ $thread->path() }}">{{ $thread->title }}</a>
            <div class="body">{{ $thread->body }}</div>
        </article>
        <hr>
        @endforeach
    </div>

</div>