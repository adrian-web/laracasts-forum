<x-guest-layout>

    <div class="mb-3">
        <a href="/threads">Threads</a>
    </div>

    <div>

        <h3 class="mb-3">
            {{ __('Create a thread') }}
        </h3>

        @if (auth()->check())

        <form action="/threads" method="POST">
            @csrf
            <div>
                <label for="title">title:</label>
                <input type="text" id="title" name="title">
            </div>

            <div>
                <label for=" body">Body:</label>
                <textarea name="body" id="body" cols="30" rows="10"></textarea>
            </div>

            <button type="submit" class="button">Publish</button>
        </form>
        {{-- @else
        <a href="{{ route('login') }}">Please sign in</a> --}}

        @endif

    </div>

</x-guest-layout>