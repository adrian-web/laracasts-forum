<h2>
    {{ __('Thread') }}
</h2>

<div>

    <div>
        <article>
            <h4>{{ $thread->title }}</h4>
            <div class="body">{{ $thread->body }}</div>
        </article>

    </div>

    <h3>
        {{ __('Replies') }}
    </h3>

    <div>
        @foreach ($thread->replies as $reply)
        <h4> <a href="#">{{ $reply->owner->name }}</a> {{ ' replied ' . $reply->created_at->diffForHumans() }}</h4>
        <div class="body">{{ $reply->body }}</div>
        <hr>
        @endforeach
    </div>

</div>