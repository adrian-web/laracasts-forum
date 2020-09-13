<h2 class="font-semibold text-xl text-gray-800 leading-tight">
    {{ __('Thread') }}
</h2>


<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
            <article>
                <h4>{{ $thread->title }}</h4>
                <div class="body">{{ $thread->body }}</div>
            </article>


        </div>
    </div>
</div>