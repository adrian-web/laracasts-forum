<div x-data="{ shown: false, timeout: null }"
    x-init="() => { clearTimeout(timeout); shown = true; setTimeout(() => { shown = false }, 3000); }"
    x-show.transition.opacity.out.duration.1500ms="shown" style="display: none;"
    class="fixed right-5 bottom-5
    px-4 py-2 bg-green-500 border border-transparent rounded-md font-semibold text-sm text-white tracking-widest hover:bg-green-400 transition ease-in-out duration-150">
    {{ session('message') }}
</div>